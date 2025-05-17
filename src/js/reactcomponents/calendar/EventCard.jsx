import React from 'react';

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
        <h3 className="text-2xl font-semibold mb-2 flex items-center">
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
          <span className="text-2xl font-semibold">£15</span>
          <span>
            Concessions:{' '}
            <span className="text-2xl font-semibold">£12</span>
          </span>
        </div>

        <ul className="flex flex-wrap mb-4 -mx-2">
          {/* Comedian 1 */}
          <li className="w-full md:w-1/3 px-2 mb-4 flex flex-col items-center relative">
            <a
              href="https://thetopsecretcomedyclub.co.uk/comedians/thomas-green/"
              className="absolute inset-0"
            />
            <div className="w-full overflow-hidden mb-2">
              <picture>
                <source
                  media="(max-width:799px)"
                  srcSet="https://…-200x300.jpeg"
                />
                <source
                  media="(min-width:800px)"
                  srcSet="https://…-768x1152.jpeg"
                />
                <img
                  src="https://…-200x300.jpeg"
                  alt="Thomas Green"
                  className="w-full h-auto block"
                />
              </picture>
            </div>
            <p className="text-center">Thomas Green</p>
          </li>

          {/* Secret Guest */}
          <li className="w-full md:w-1/3 px-2 mb-4 flex flex-col items-center relative">
            <a
              href="https://…/special-celebrity-guest/"
              className="absolute inset-0"
            />
            <div className="flex flex-col items-center mb-2">
              <div className="flex items-center space-x-1 animate-pulse">
                <div className="text-xl">?</div>
                <div className="text-sm uppercase">Top secret</div>
              </div>
              <span className="text-xs uppercase tracking-wider">
                celebrity guest
              </span>
              <div className="w-16 h-16 mt-2">
                <img
                  src="https://…/secret.png"
                  alt="Secret Guest"
                  className="w-full h-full object-contain"
                />
              </div>
            </div>
            <p className="text-center">Secret Celebrity Guest!</p>
          </li>
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
