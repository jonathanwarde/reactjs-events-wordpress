import React, { useState } from "react";
import DatePicker from "react-datepicker";
import CalButton from "./CalButton.jsx"

import "react-datepicker/dist/react-datepicker.css";
import 'react-datepicker/dist/react-datepicker-cssmodules.css';
import '../../../scss/react-components/datepicker.scss';

export const CalendarDatePicker = () => {
  const [startDate, setStartDate] = useState(new Date());
  const [selectedDate, setSelectedDate] = useState('Today')
  const [isOpen, setIsOpen] = useState(false);
  const handleChange = (date) => {
    setStartDate(date); 
    const formattedDate = date.toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short' });
    setSelectedDate(formattedDate); 
    setIsOpen(false);
  };
  const handleClick = (e) => {
    e.preventDefault();
    setIsOpen(!isOpen);
  };

  const today = new Date();
  const todayFormatted = today.toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short' });

  const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
  const tomorrowFormatted = tomorrow.toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short' });

  const dayAfterTomorrow = new Date(today);
        dayAfterTomorrow.setDate(today.getDate() + 2);
  const dayAfterTomorrowFormatted = dayAfterTomorrow.toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short' });

  function handleDateClick(date) {
    setSelectedDate(date)
  }

  return (
      <>
      <div className="flex font-heading gap-x-4 justify-between m-auto max-w-7xl md:gap-x-15 px-4 py-6 sm:px-8 sm:py-16">
          <h3 className="text-3xl">{selectedDate}</h3>
            <ol className="flex gap-4">
                <li className="relative">
                    <span class="absolute text-xs bg-primary z-10 px-1 left-6 top-[-4px]">Today</span>
                    <CalButton date={todayFormatted} onClick={() => handleDateClick(todayFormatted)} />
                </li>
                <li>
                    <CalButton date={tomorrowFormatted} onClick={() => handleDateClick(tomorrowFormatted)} />
                </li>
                <li>
                    <CalButton date={dayAfterTomorrowFormatted} onClick={() => handleDateClick(dayAfterTomorrowFormatted)}  />
                </li>
                <li className="relative">
                <button onClick={handleClick} className="border border-white flex flex-col h-[80px] justify-center leading-none text-sm w-[80px] custom-triangle relative">
                    <span>other</span><span>day</span>
                </button>
                {isOpen && (
                    <DatePicker selected={startDate} onChange={handleChange} inline className="absolute" />
                )}
                </li>
            </ol>
      </div>
      </>
  )
};
export default CalendarDatePicker