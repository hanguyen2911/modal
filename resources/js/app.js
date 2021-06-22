import React from 'react';
import ReactDOM from 'react-dom';
import  "bootstrap/dist/css/bootstrap.css";
import CarList from './components/carList.component';
function App() {
    return (
        <div className="container">
           <CarList/>
        </div>
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
