<?php

declare(strict_types=1);

namespace App\Service\User;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

readonly class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $bookStoreLogger,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository,
        private JWTTokenManagerInterface $jwtTokenManager,
    ) {
    }

    public function register(string $email, string $plainPassword, string $displayName): UserDTO
    {
        $user = new User($email);
        $user->setDisplayName($displayName);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->bookStoreLogger->info('User registered successfully.', [
                'user_uuid' => $user->getId()->toString(),
                'email' => $email,
            ]);

            return UserDTO::fromUser($user);
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('User registration failed.', [
                'email' => $email,
                'error_message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * @throws \Throwable
     *
     * @return array{jwtToken: string, user: UserDTO}
     */
    public function login(string $email, string $plainPassword): array
    {
        $existingUser = $this->userRepository->findByEmail($email);

        try {
            if (null === $existingUser || ! $this->passwordHasher->isPasswordValid($existingUser, $plainPassword)) {
                throw new BadCredentialsException('Invalid email or password.');
            }

            $jwtToken = $this->jwtTokenManager->create($existingUser);

            $this->bookStoreLogger->info('User logged in successfully.', [
                'user_uuid' => $existingUser->getId()->toString(),
                'email' => $email,
            ]);

            return [
                'jwtToken' => $jwtToken,
                'user' => UserDTO::fromUser($existingUser),
            ];
        } catch (\Throwable $exception) {
            $this->bookStoreLogger->error('User login failed', [
                'email' => $email,
                'error_message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}
