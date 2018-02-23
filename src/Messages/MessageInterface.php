<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Messages;

/**
 * Interface MessageInterface.
 *
 * Message interface.
 */
interface MessageInterface
{
    /**
     * Get server ID.
     *
     * @return int
     */
    public function getServerId();

    /**
     * Get phone number.
     *
     * @return string
     */
    public function getPhone();

    /**
     * Get status code.
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * Get status message as a string.
     *
     * @return string
     */
    public function getStatus();
}
