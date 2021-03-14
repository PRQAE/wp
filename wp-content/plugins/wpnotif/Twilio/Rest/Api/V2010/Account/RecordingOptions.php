<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;

abstract class RecordingOptions {
	/**
	 * @param string $dateCreatedBefore Filter by date created
	 * @param string $dateCreated Filter by date created
	 * @param string $dateCreatedAfter Filter by date created
	 * @param string $callSid Filter by call_sid
	 * @param string $conferenceSid The unique ID for the conference associated
	 *                              with the recording.
	 *
	 * @return ReadRecordingOptions Options builder
	 */
	public static function read( $dateCreatedBefore = Values::NONE, $dateCreated = Values::NONE, $dateCreatedAfter = Values::NONE, $callSid = Values::NONE, $conferenceSid = Values::NONE ) {
		return new ReadRecordingOptions( $dateCreatedBefore, $dateCreated, $dateCreatedAfter, $callSid, $conferenceSid );
	}
}

class ReadRecordingOptions extends Options {
	/**
	 * @param string $dateCreatedBefore Filter by date created
	 * @param string $dateCreated Filter by date created
	 * @param string $dateCreatedAfter Filter by date created
	 * @param string $callSid Filter by call_sid
	 * @param string $conferenceSid The unique ID for the conference associated
	 *                              with the recording.
	 */
	public function __construct( $dateCreatedBefore = Values::NONE, $dateCreated = Values::NONE, $dateCreatedAfter = Values::NONE, $callSid = Values::NONE, $conferenceSid = Values::NONE ) {
		$this->options['dateCreatedBefore'] = $dateCreatedBefore;
		$this->options['dateCreated']       = $dateCreated;
		$this->options['dateCreatedAfter']  = $dateCreatedAfter;
		$this->options['callSid']           = $callSid;
		$this->options['conferenceSid']     = $conferenceSid;
	}

	/**
	 * Only show recordings created on the given date. Should be formatted `YYYY-MM-DD`. You can also specify inequality: `DateCreated<=YYYY-MM-DD` will return recordings generated at or before midnight on a given date, and `DateCreated>=YYYY-MM-DD` returns recordings generated at or after midnight on a date.
	 *
	 * @param string $dateCreatedBefore Filter by date created
	 *
	 * @return $this Fluent Builder
	 */
	public function setDateCreatedBefore( $dateCreatedBefore ) {
		$this->options['dateCreatedBefore'] = $dateCreatedBefore;

		return $this;
	}

	/**
	 * Only show recordings created on the given date. Should be formatted `YYYY-MM-DD`. You can also specify inequality: `DateCreated<=YYYY-MM-DD` will return recordings generated at or before midnight on a given date, and `DateCreated>=YYYY-MM-DD` returns recordings generated at or after midnight on a date.
	 *
	 * @param string $dateCreated Filter by date created
	 *
	 * @return $this Fluent Builder
	 */
	public function setDateCreated( $dateCreated ) {
		$this->options['dateCreated'] = $dateCreated;

		return $this;
	}

	/**
	 * Only show recordings created on the given date. Should be formatted `YYYY-MM-DD`. You can also specify inequality: `DateCreated<=YYYY-MM-DD` will return recordings generated at or before midnight on a given date, and `DateCreated>=YYYY-MM-DD` returns recordings generated at or after midnight on a date.
	 *
	 * @param string $dateCreatedAfter Filter by date created
	 *
	 * @return $this Fluent Builder
	 */
	public function setDateCreatedAfter( $dateCreatedAfter ) {
		$this->options['dateCreatedAfter'] = $dateCreatedAfter;

		return $this;
	}

	/**
	 * Only show recordings made during the call indicated by this call SID
	 *
	 * @param string $callSid Filter by call_sid
	 *
	 * @return $this Fluent Builder
	 */
	public function setCallSid( $callSid ) {
		$this->options['callSid'] = $callSid;

		return $this;
	}

	/**
	 * The unique ID for the conference associated with the recording, if the recording is of a conference.
	 *
	 * @param string $conferenceSid The unique ID for the conference associated
	 *                              with the recording.
	 *
	 * @return $this Fluent Builder
	 */
	public function setConferenceSid( $conferenceSid ) {
		$this->options['conferenceSid'] = $conferenceSid;

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

		return '[Twilio.Api.V2010.ReadRecordingOptions ' . implode( ' ', $options ) . ']';
	}
}