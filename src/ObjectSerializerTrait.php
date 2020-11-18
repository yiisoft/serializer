<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

use InvalidArgumentException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;

use function class_exists;
use function gettype;
use function is_array;
use function is_object;
use function sprintf;

trait ObjectSerializerTrait
{
    private Serializer $serializer;

    /**
     * Restores object from the decoded data.
     *
     * @param array $data The decoded data for restoring the object.
     * @param string $class The class name of the object to be restored.
     * @return object The restored object.
     * @throws InvalidArgumentException If the data to restore the object is incorrect.
     * @psalm-suppress InvalidReturnType
     */
    private function denormalizeObject(array $data, string $class): object
    {
        try {
            return $this->serializer->denormalize($data, $class);
        } catch (ExceptionInterface $e) {
            throw new InvalidArgumentException(sprintf(
                'The data for restoring the object is incorrect. %s',
                $e->getMessage()
            ));
        }
    }

    /**
     * Restores array objects from the decoded data.
     *
     * @param array[] $data The decoded data for restoring the object.
     * @param string $class The class name of the objects to be restored.
     * @return object[] The restored array objects.
     * @throws InvalidArgumentException If the data to restore the objects is incorrect.
     * @psalm-suppress InvalidReturnType
     */
    private function denormalizeObjects(array $data, string $class): array
    {
        foreach ($data as $key => $value) {
            $data[$key] = $this->denormalizeObject($value, $class);
        }

        return $data;
    }

    /**
     * Checks and decodes data from its serialized representations.
     *
     * @param string $data The serialized string.
     * @param string $class The name of the object class to be restored.
     * @param string $format The format of the sterilized data.
     * @return array The decoded data.
     * @throws InvalidArgumentException if class does not exist or data to restore the object is incorrect.
     */
    private function checkAndDecodeData(string $data, string $class, string $format): array
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf(
                'The "%s" class does not exist.',
                $class
            ));
        }

        $decodedData = $this->serializer->decode($data, $format);

        if (!is_array($decodedData)) {
            throw new InvalidArgumentException('The data for restoring the object is incorrect.');
        }

        return $decodedData;
    }

    /**
     * Checks that each item of the array is an object.
     *
     * @param array $objects
     * @throws InvalidArgumentException if the array of objects is incorrect.
     */
    private function checkArrayObjects(array $objects): void
    {
        foreach ($objects as $object) {
            if (!is_object($object)) {
                throw new InvalidArgumentException(sprintf(
                    'The array item must be an object, %s received.',
                    gettype($object)
                ));
            }
        }
    }
}
