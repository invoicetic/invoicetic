<?php

namespace Invoicetic;

use Invoicetic\Common\Gateway\GatewayFactory;

class Invoicetic
{

    /**
     * Internal factory storage
     *
     * @var GatewayFactory
     */
    private static ?GatewayFactory $factory = null;

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewayFactory A GatewayFactory instance
     */
    public static function getFactory(): GatewayFactory
    {
        if (is_null(self::$factory)) {
            self::$factory = new GatewayFactory;
        }

        return self::$factory;
    }

    /**
     * Set the gateway factory
     *
     * @param GatewayFactory|null $factory A GatewayFactory instance
     */
    public static function setFactory(GatewayFactory $factory = null): void
    {
        self::$factory = $factory;
    }

    /**
     * Static function call router.
     *
     * All other function calls to the Omnipay class are routed to the
     * factory.  e.g. Omnipay::getSupportedGateways(1, 2, 3, 4) is routed to the
     * factory's getSupportedGateways method and passed the parameters 1, 2, 3, 4.
     *
     * Example:
     *
     * <code>
     *   // Create a gateway for the PayPal ExpressGateway
     *   $gateway = Omnipay::create('ExpressGateway');
     * </code>
     *
     * @see GatewayFactory
     *
     * @param string $method     The factory method to invoke.
     * @param array  $parameters Parameters passed to the factory method.
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $factory = self::getFactory();

        return call_user_func_array(array($factory, $method), $parameters);
    }

}

