import React from 'react';
import ReactDOM from 'react-dom';
import { CalendarDatePicker } from './js/reactcomponents/calendar/Calendar.jsx';


function App() {
  return <div className="">
    <CalendarDatePicker />
    </div>;
}
const element = document.getElementById('react-root');
if (element) {
  ReactDOM.render(<App />, element);
}
