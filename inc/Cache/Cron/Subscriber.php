<?php
namespace LaunchpadRenderer\Cache\Cron;
use LaunchpadCore\EventManagement\SubscriberInterface;
use function LaunchpadRenderer\Cron\wp_next_scheduled;
use function LaunchpadRenderer\Cron\wp_schedule_event;

class Subscriber implements SubscriberInterface {

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var bool
     */
    protected $renderer_cache_enabled;



    /**
     * Returns an array of events that this subscriber wants to listen to.
     *
     * The array key is the event name. The value can be:
     *
     *  * The method name
     *  * An array with the method name and priority
     *  * An array with the method name, priority and number of accepted arguments
     *
     * For instance:
     *
     *  * array('hook_name' => 'method_name')
     *  * array('hook_name' => array('method_name', $priority))
     *  * array('hook_name' => array('method_name', $priority, $accepted_args))
     *  * array('hook_name' => array(array('method_name_1', $priority_1, $accepted_args_1)), array('method_name_2', $priority_2, $accepted_args_2)))
     *
     * @return array
     */
    public function get_subscribed_events() {
        return [
            '' => 'register_event',
        ];
    }

    public function register_event() {
        if ( wp_next_scheduled( "{$this->prefix}_renderer_clear_cache" ) || ! $this->renderer_cache_enabled ) {
            return;
        }

        wp_schedule_event( time() + 10 * MINUTE_IN_SECONDS, "{$this->prefix}_renderer_clear_cache", "{$this->prefix}_renderer_clear_cache" );
    }

    public function register_interval($schedules) {

        if(! $this->renderer_cache_enabled) {
            return $schedules;
        }

        /**
         * Filters the cron interval.
         *
         * @since 3.11
         *
         * @param int $interval Interval in seconds.
         */
        $interval = apply_filters( "{$this->prefix}_renderer_clear_cache_interval", 1 * MINUTE_IN_SECONDS );

        $schedules["{$this->prefix}_renderer_clear_cache"] = [
            'interval' => $interval,
            'display'  => 'Renderer clear cache',
        ];

        return $schedules;
    }

    public function clear_expired_cache() {

    }
}
