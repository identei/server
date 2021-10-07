<?php
/**
 * @copyright 2017, Georg Ehrke <oc.list@georgehrke.com>
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @author Georg Ehrke <oc.list@georgehrke.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OC\Calendar;

use OCP\AppFramework\Utility\ITimeFactory;
use OCP\Calendar\ICalendar;
use OCP\Calendar\ICalendarProvider;

class CalendarQuery implements \OCP\Calendar\ICalendarQuery {

	/** @var string */
	private $principalUri;

	/** @var array */
	public $searchProperties;

	/** @var string */
	private $searchPattern;

	/** @var array */
	private $options;

	/** @var int */
	private $offset;

	/** @var int */
	private $limit;

	/** @var array */
	private $calendarUris;

	public function __construct(string $principalUri) {
		$this->principalUri = $principalUri;
		$this->searchProperties = [];
		$this->options = [];
	}

	public function getPrincipalUri(): string {
		return $this->principalUri;
	}

	public function setPrincipalUri(string $principalUri): void {
		$this->principalUri = $principalUri;
	}

	public function getSearchPattern(): string {
		return $this->searchPattern ?? '';
	}

	public function setSearchPattern(string $pattern): void {
		$this->searchPattern = $pattern;
	}

	public function getSearchProperties(): array {
		return $this->searchProperties;
	}

	public function setSearchProperty(string $value): void {
		$this->searchProperties[] = $value;
	}

	public function getOptions(): array {
		return $this->options;
	}

	public function setOptions(string $key, string $value): void {
		$this->options[$key] = $value;
	}

	public function getLimit(): ?int {
		return $this->limit ?? null;
	}

	public function setLimit(int $limit): void {
		$this->limit = $limit;
	}

	public function getOffset(): ?int {
		return $this->offset ?? null;
	}

	public function setOffset(int $offset): void {
		$this->offset = $offset;
	}

	public function searchAttendee(): void {
		$this->searchProperties[] = 'ATTENDEE';
	}

	public function searchOrganizer(): void {
		$this->searchProperties[] = 'ORGANIZER';
	}

	public function searchSummary(): void {
		$this->searchProperties[] = 'SUMMARY';
	}

	public function searchAppointments(): void {
		$this->searchProperties[] = 'X-NC-APPOINTMENT';
	}

	public function setTimerangeStart(\DateTime $startTime): void {
		$this->options['timerange']['start'] = $startTime;
	}

	public function setTimerangeEnd(\DateTime $endTime): void {
		$this->options['timerange']['end'] = $endTime;
	}

	public function setSearchCalendar(string $calendarUri): void {
		$this->calendarUris[] = $calendarUri;
	}

	public function getCalendarUris(): array {
		return $this->calendarUris;
	}
}
