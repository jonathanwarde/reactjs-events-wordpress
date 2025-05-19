import React from 'react';
import EventCardComedians from './EventCardComedians';

export const EventCard = ({event}) => {

  const venueAddress = () => {
    switch(event.venue) {
      case "kingsway":
        return "23 Kingsway";
        break;
      case "drurylanebasement":
        return "170 Drury Lane (basement)";
        break;
      case "drurylaneground":
        return "170 Drury Lane (ground floor)";
        break;
      default:
        return "170 Drury Lane";
    }
  }

  const venuePin = () => {
    switch(event.venue) {
      case "kingsway":
        return "kingsway";
        break;
      case "drurylanebasement":
        return "drurylane";
        break;
      case "drurylaneground":
        return "drurylane";
        break;
      default:
        return "drurylane";
    }
  }

  return (
    <li className="relative p-5 border border-white flex flex-col">
      <div className="flex-1">
        <h3 className="text-2xl font-semibold mb-2 flex flex-col items-start">
          {event.title}
          <span className="ml-2 text-sm text-gray-300">
            <a
              href={`/find-us/#${venuePin()}`}
              target="_blank"
              className="inline-flex items-center"
            >
              <svg className="w-4 h-4 mr-1">
                <use href="#icon-search-pin" />
              </svg>
              {venueAddress()}
            </a>
          </span>
        </h3>

        <div className="flex justify-between pb-4 text-sm">
          <span>Starts: {event.start_time}</span>
          <span>Doors: {event.doors_time}</span>
        </div>

        <div className="flex justify-between pb-4 text-sm">
          <span className="text-2xl font-semibold">{event.currency}{event.price}</span>
          {
            event.price !== event.concession && (
              <span>
              Concessions:
              <span className="text-2xl font-semibold">{event.currency}{event.concession}</span>
            </span>
            )}
        </div>
        <ul className="flex flex-wrap mb-4 -mx-2 min-h-[187px]">
        <EventCardComedians event={event} />
        </ul>
      </div>

      <div className="flex justify-between mt-4 space-x-2">
        <a
          href={event.permalink}
          className="flex-1 text-center py-2 border border-transparent bg-black text-white rounded-md min-w-[160px]"
        >
          more
        </a>
        <a 
          href={event.ticket_url}
          className="flex-1 text-center py-2 border border-white text-white rounded-md min-w-[160px]"
        >
          book
        </a>
      </div>
    </li>
  );
};

export default EventCard;
