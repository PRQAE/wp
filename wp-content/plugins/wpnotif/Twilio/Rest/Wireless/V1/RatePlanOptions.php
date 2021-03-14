<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Wireless\V1;

use Twilio\Options;
use Twilio\Values;

abstract class RatePlanOptions {
	/**
	 * @param string $uniqueName A user-provided string that uniquely identifies
	 *                           this resource as an alternative to the Sid.
	 * @param string $friendlyName A user-provided string that identifies this
	 *                             resource.
	 * @param boolean $dataEnabled Defines whether SIMs are capable of using
	 *                             GPRS/3G/LTE data connectivity.
	 * @param integer $dataLimit Network-enforced limit specifying the total
	 *                           Megabytes of data usage allowed during one month
	 *                           on the home network.
	 * @param string $dataMetering The model by which to meter data usage, in
	 *                             accordance with the two available data metering
	 *                             models.
	 * @param boolean $messagingEnabled Defines whether SIMs are capable of making
	 *                                  and sending and receiving SMS messages via
	 *                                  either Commands or Programmable SMS APIs.
	 * @param boolean $voiceEnabled Defines whether SIMs are capable of making and
	 *                              receiving voice calls.
	 * @param boolean $nationalRoamingEnabled Defines whether SIMs can roam onto
	 *                                        other networks in the SIM's home
	 *                                        country.
	 * @param string $internationalRoaming The international_roaming
	 * @param integer $nationalRoamingDataLimit Network-enforced limit specifying
	 *                                          the total Megabytes of national
	 *                                          roaming data usage allowed during
	 *                                          one month.
	 * @param integer $internationalRoamingDataLimit The
	 *                                               international_roaming_data_limit
	 *
	 * @return CreateRatePlanOptions Options builder
	 */
	public static function create( $uniqueName = Values::NONE, $friendlyName = Values::NONE, $dataEnabled = Values::NONE, $dataLimit = Values::NONE, $dataMetering = Values::NONE, $messagingEnabled = Values::NONE, $voiceEnabled = Values::NONE, $nationalRoamingEnabled = Values::NONE, $internationalRoaming = Values::NONE, $nationalRoamingDataLimit = Values::NONE, $internationalRoamingDataLimit = Values::NONE ) {
		return new CreateRatePlanOptions( $uniqueName, $friendlyName, $dataEnabled, $dataLimit, $dataMetering, $messagingEnabled, $voiceEnabled, $nationalRoamingEnabled, $internationalRoaming, $nationalRoamingDataLimit, $internationalRoamingDataLimit );
	}

	/**
	 * @param string $uniqueName A user-provided string that uniquely identifies
	 *                           this resource as an alternative to the Sid.
	 * @param string $friendlyName A user-provided string that identifies this
	 *                             resource.
	 *
	 * @return UpdateRatePlanOptions Options builder
	 */
	public static function update( $uniqueName = Values::NONE, $friendlyName = Values::NONE ) {
		return new UpdateRatePlanOptions( $uniqueName, $friendlyName );
	}
}

class CreateRatePlanOptions extends Options {
	/**
	 * @param string $uniqueName A user-provided string that uniquely identifies
	 *                           this resource as an alternative to the Sid.
	 * @param string $friendlyName A user-provided string that identifies this
	 *                             resource.
	 * @param boolean $dataEnabled Defines whether SIMs are capable of using
	 *                             GPRS/3G/LTE data connectivity.
	 * @param integer $dataLimit Network-enforced limit specifying the total
	 *                           Megabytes of data usage allowed during one month
	 *                           on the home network.
	 * @param string $dataMetering The model by which to meter data usage, in
	 *                             accordance with the two available data metering
	 *                             models.
	 * @param boolean $messagingEnabled Defines whether SIMs are capable of making
	 *                                  and sending and receiving SMS messages via
	 *                                  either Commands or Programmable SMS APIs.
	 * @param boolean $voiceEnabled Defines whether SIMs are capable of making and
	 *                              receiving voice calls.
	 * @param boolean $nationalRoamingEnabled Defines whether SIMs can roam onto
	 *                                        other networks in the SIM's home
	 *                                        country.
	 * @param string $internationalRoaming The international_roaming
	 * @param integer $nationalRoamingDataLimit Network-enforced limit specifying
	 *                                          the total Megabytes of national
	 *                                          roaming data usage allowed during
	 *                                          one month.
	 * @param integer $internationalRoamingDataLimit The
	 *                                               international_roaming_data_limit
	 */
	public function __construct( $uniqueName = Values::NONE, $friendlyName = Values::NONE, $dataEnabled = Values::NONE, $dataLimit = Values::NONE, $dataMetering = Values::NONE, $messagingEnabled = Values::NONE, $voiceEnabled = Values::NONE, $nationalRoamingEnabled = Values::NONE, $internationalRoaming = Values::NONE, $nationalRoamingDataLimit = Values::NONE, $internationalRoamingDataLimit = Values::NONE ) {
		$this->options['uniqueName']                    = $uniqueName;
		$this->options['friendlyName']                  = $friendlyName;
		$this->options['dataEnabled']                   = $dataEnabled;
		$this->options['dataLimit']                     = $dataLimit;
		$this->options['dataMetering']                  = $dataMetering;
		$this->options['messagingEnabled']              = $messagingEnabled;
		$this->options['voiceEnabled']                  = $voiceEnabled;
		$this->options['nationalRoamingEnabled']        = $nationalRoamingEnabled;
		$this->options['internationalRoaming']          = $internationalRoaming;
		$this->options['nationalRoamingDataLimit']      = $nationalRoamingDataLimit;
		$this->options['internationalRoamingDataLimit'] = $internationalRoamingDataLimit;
	}

	/**
	 * A user-provided string that uniquely identifies this resource as an alternative to the Sid.
	 *
	 * @param string $uniqueName A user-provided string that uniquely identifies
	 *                           this resource as an alternative to the Sid.
	 *
	 * @return $this Fluent Builder
	 */
	public function setUniqueName( $uniqueName ) {
		$this->options['uniqueName'] = $uniqueName;

		return $this;
	}

	/**
	 * A user-provided string that identifies this resource. Non-unique.
	 *
	 * @param string $friendlyName A user-provided string that identifies this
	 *                             resource.
	 *
	 * @return $this Fluent Builder
	 */
	public function setFriendlyName( $friendlyName ) {
		$this->options['friendlyName'] = $friendlyName;

		return $this;
	}

	/**
	 * Defines whether SIMs are capable of using GPRS/3G/LTE data connectivity.
	 *
	 * @param boolean $dataEnabled Defines whether SIMs are capable of using
	 *                             GPRS/3G/LTE data connectivity.
	 *
	 * @return $this Fluent Builder
	 */
	public function setDataEnabled( $dataEnabled ) {
		$this->options['dataEnabled'] = $dataEnabled;

		return $this;
	}

	/**
	 * Network-enforced limit specifying the total Megabytes of data usage (download and upload combined) allowed during one month on the home network. Metering begins on the day of activation and ends on the same day of the following month.  Max value is 2TB.
	 *
	 * @param integer $dataLimit Network-enforced limit specifying the total
	 *                           Megabytes of data usage allowed during one month
	 *                           on the home network.
	 *
	 * @return $this Fluent Builder
	 */
	public function setDataLimit( $dataLimit ) {
		$this->options['dataLimit'] = $dataLimit;

		return $this;
	}

	/**
	 * The model by which to meter data usage, in accordance with the two available [data metering models](https://www.twilio.com/docs/api/wireless/rest-api/rate-plan#explanation-of-pooled-vs-individual). Valid options are `pooled` and `individual`.
	 *
	 * @param string $dataMetering The model by which to meter data usage, in
	 *                             accordance with the two available data metering
	 *                             models.
	 *
	 * @return $this Fluent Builder
	 */
	public function setDataMetering( $dataMetering ) {
		$this->options['dataMetering'] = $dataMetering;

		return $this;
	}

	/**
	 * Defines whether SIMs are capable of making and sending and receiving SMS messages via either [Commands](https://www.twilio.com/docs/wireless/api/commands) or Programmable SMS APIs.
	 *
	 * @param boolean $messagingEnabled Defines whether SIMs are capable of making
	 *                                  and sending and receiving SMS messages via
	 *                                  either Commands or Programmable SMS APIs.
	 *
	 * @return $this Fluent Builder
	 */
	public function setMessagingEnabled( $messagingEnabled ) {
		$this->options['messagingEnabled'] = $messagingEnabled;

		return $this;
	}

	/**
	 * Defines whether SIMs are capable of making and receiving voice calls.
	 *
	 * @param boolean $voiceEnabled Defines whether SIMs are capable of making and
	 *                              receiving voice calls.
	 *
	 * @return $this Fluent Builder
	 */
	public function setVoiceEnabled( $voiceEnabled ) {
		$this->options['voiceEnabled'] = $voiceEnabled;

		return $this;
	}

	/**
	 * Defines whether SIMs can roam onto other networks in the SIM's home country. See ['national' roaming](https://www.twilio.com/docs/api/wireless/rest-api/rate-plan#national-roaming).
	 *
	 * @param boolean $nationalRoamingEnabled Defines whether SIMs can roam onto
	 *                                        other networks in the SIM's home
	 *                                        country.
	 *
	 * @return $this Fluent Builder
	 */
	public function setNationalRoamingEnabled( $nationalRoamingEnabled ) {
		$this->options['nationalRoamingEnabled'] = $nationalRoamingEnabled;

		return $this;
	}

	/**
	 * The international_roaming
	 *
	 * @param string $internationalRoaming The international_roaming
	 *
	 * @return $this Fluent Builder
	 */
	public function setInternationalRoaming( $internationalRoaming ) {
		$this->options['internationalRoaming'] = $internationalRoaming;

		return $this;
	}

	/**
	 * Network-enforced limit specifying the total Megabytes of national roaming data usage (download and upload combined) allowed during one month.  Max value is 2TB. If unspecified, the default value is the lesser of `DataLimit` and 1000MB.
	 *
	 * @param integer $nationalRoamingDataLimit Network-enforced limit specifying
	 *                                          the total Megabytes of national
	 *                                          roaming data usage allowed during
	 *                                          one month.
	 *
	 * @return $this Fluent Builder
	 */
	public function setNationalRoamingDataLimit( $nationalRoamingDataLimit ) {
		$this->options['nationalRoamingDataLimit'] = $nationalRoamingDataLimit;

		return $this;
	}

	/**
	 * The international_roaming_data_limit
	 *
	 * @param integer $internationalRoamingDataLimit The
	 *                                               international_roaming_data_limit
	 *
	 * @return $this Fluent Builder
	 */
	public function setInternationalRoamingDataLimit( $internationalRoamingDataLimit ) {
		$this->options['internationalRoamingDataLimit'] = $internationalRoamingDataLimit;

		return $this;
	}

	/**
	 * Provide a friendly representation
	 *
	 * @return string Machine friendly representation
	 */
	public function __toString() {
		$options = array();
		foreach ( $this->options as $key => $value ) {
			if ( $value != Values::NONE ) {
				$options[] = "$key=$value";
			}
		}

		return '[Twilio.Wireless.V1.CreateRatePlanOptions ' . implode( ' ', $options ) . ']';
	}
}

class UpdateRatePlanOptions extends Options {
	/**
	 * @param string $uniqueName A user-provided string that uniquely identifies
	 *                           this resource as an alternative to the Sid.
	 * @param string $friendlyName A user-provided string that identifies this
	 *                             resource.
	 */
	public function __construct( $uniqueName = Values::NONE, $friendlyName = Values::NONE ) {
		$this->options['uniqueName']   = $uniqueName;
		$this->options['friendlyName'] = $friendlyName;
	}

	/**
	 * A user-provided string that uniquely identifies this resource as an alternative to the Sid.
	 *
	 * @param string $uniqueName A user-provided string that uniquely identifies
	 *                           this resource as an alternative to the Sid.
	 *
	 * @return $this Fluent Builder
	 */
	public function setUniqueName( $uniqueName ) {
		$this->options['uniqueName'] = $uniqueName;

		return $this;
	}

	/**
	 * A user-provided string that identifies this resource. Non-unique.
	 *
	 * @param string $friendlyName A user-provided string that identifies this
	 *                             resource.
	 *
	 * @return $this Fluent Builder
	 */
	public function setFriendlyName( $friendlyName ) {
		$this->options['friendlyName'] = $friendlyName;

		return $this;
	}

	/**
	 * Provide a friendly representation
	 *
	 * @return string Machine friendly representation
	 */
	public function __toString() {
		$options = array();
		foreach ( $this->options as $key => $value ) {
			if ( $value != Values::NONE ) {
				$options[] = "$key=$value";
			}
		}

		return '[Twilio.Wireless.V1.UpdateRatePlanOptions ' . implode( ' ', $options ) . ']';
	}
}