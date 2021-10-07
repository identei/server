<?php
/**
 * @copyright 2021 Anna Larch <anna.larch@gmx.net>
 *
 * @author Anna Larch <anna.larch@gmx.net>
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
namespace OCA\DAV\CalDAV;

use OCP\Calendar\ICalendar;
use OCP\Calendar\ICalendarProvider;
use OCP\Constants;
use OCP\IConfig;
use OCP\IL10N;

class CalendarProvider implements ICalendarProvider {

	/** @var CalDavBackend */
	private $calDavBackend;

	/**
	 * @param CalDavBackend $calDavBackend
	 */
	public function __construct(CalDavBackend $calDavBackend, IL10N $l10n, IConfig $config) {
		$this->calDavBackend = $calDavBackend;
		$this->l10n = $l10n;
		$this->config = $config;
	}

	public function getCalendars(string $principalUri, array $calendarUris = []): array {
		$calendars = [];
		$iCalendars = [];
		if(empty($calendarUris)) {
			$calendars[] = $this->calDavBackend->getCalendarsForUser($principalUri);
		}

		$calendars = [];
		foreach ($calendarUris as $calendarUri) {
			$calendars[] = $this->calDavBackend->getCalendarByUri($principalUri, $calendarUri);
		}

		foreach ($calendars as $calendarInfo) {
			$calendar = new Calendar($this->calDavBackend, $calendarInfo, $this->l10n, $this->config);
			$iCalendars[] = new CalendarImpl(
				$calendar,
				$calendarInfo,
				$this->calDavBackend
			);
		}
		return $iCalendars;
	}
}
