import React from 'react';
import ReactDOM from 'react-dom';
import {CalendarDatePicker} from './js/reactcomponents/Calendar';

function App() {
  return <div className="text-2xl font-heading">
    <CalendarDatePicker />
    Entry point for events...
    </div>;
}
const element = document.getElementById('react-root');
if (element) {
  ReactDOM.render(<App />, element);
}
