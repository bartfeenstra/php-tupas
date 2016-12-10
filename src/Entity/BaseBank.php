<?php

namespace Tupas\Entity;

/**
 * Class BaseBank.
 *
 * @package Tupas\Entity
 */
abstract class BaseBank implements BankInterface
{
    /**
     * The action id.
     *
     * All the banks use the same action id.
     *
     * @var int
     */
    protected $actionId = 701;

    /**
     * The url to Tupas service.
     *
     * @var string
     */
    protected $actionUrl;

    /**
     * The certificate version.
     *
     * @var string
     */
    protected $certVersion;

    /**
     * The receiver id.
     *
     * @var string
     */
    protected $receiverId;

    /**
     * The receiver key.
     *
     * @var string
     */
    protected $receiverKey;

    /**
     * The id type.
     *
     * @var string
     */
    protected $idType;

    /**
     * The key version.
     *
     * @var string
     */
    protected $keyVersion;

    /**
     * The hashing algorithm.
     *
     * @var string
     */
    protected $algorithm;

    /**
     * {@inheritdoc}
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * The setter.
     *
     * @param string $key
     *   The name of property.
     * @param mixed $value
     *   The value for given property.
     *
     * @return $this
     */
    public function set($key, $value)
    {
        if (!property_exists($this, $key)) {
            throw new \LogicException(sprintf('%s does not exist.', $key));
        }
        $this->{$key} = $value;

        return $this;
    }

    /**
     * The getter.
     *
     * @param string $key
     *   The name of property to get.
     *
     * @return mixed|null
     *   The value if found, null if not.
     */
    public function get($key)
    {
        return property_exists($this, $key) ? $this->{$key} : null;
    }
}