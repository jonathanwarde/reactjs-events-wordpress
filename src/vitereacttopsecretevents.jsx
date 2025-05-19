import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { CalendarDatePicker } from './js/reactcomponents/calendar/Calendar.jsx';
import { EventCard } from './js/reactcomponents/calendar/EventCard.jsx';

const App = () => {
  const [fetchedData, setFetchedData] = useState({ events: [] });
  const [selectedDate, setSelectedDate] = useState('Today');

  //format date to 2025-04-26 format
  const formatDate = (input) => {
    const [, dmy] = input.split(",");
    const withYear = dmy.trim() + " " + new Date().getFullYear();
    const dt = new Date(withYear);
    if (isNaN(dt)) throw new Error("Invalid date");
    const y = dt.getFullYear();
    const m = String(dt.getMonth() + 1).padStart(2, "0");
    const d = String(dt.getDate()).padStart(2, "0");
    return `${y}-${m}-${d}`;
  }
  

  const fetchData = async (date) => {
    const dateFormatted = formatDate(date)
    try {
      const response = await fetch('https://tscc.local/web/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
          'accept': 'application/json, text/plain, */*',
          'content-type': 'application/x-www-form-urlencoded;charset=UTF-8',
        },
        body: `action=jw_events_by_date_v2&date=${dateFormatted}`,
      });

      const result = await response.json();
      setFetchedData(result);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  const listFetchedEvents = fetchedData.events.map(_event =>
    <EventCard event={_event} />
  );

  return (
    <>
      <CalendarDatePicker
        selectedDate={selectedDate}
        setSelectedDate={setSelectedDate}
        fetchData={fetchData}
      />
      {fetchedData && (
        <ol className="grid gap-[30px] w-full md:[grid-template-columns:50fr_50fr]">
           {listFetchedEvents}
        </ol>
      )}
    </>
  );
};

const element = document.getElementById('react-root');
if (element) {
  ReactDOM.render(<App />, element);
}