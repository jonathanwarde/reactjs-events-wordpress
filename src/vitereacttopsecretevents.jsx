import React from 'react';
import ReactDOM from 'react-dom';

function App() {
  return <div>Entry point for events...</div>;
}
const element = document.getElementById('react-root');
if (element) {
  ReactDOM.render(<App />, element);
}
