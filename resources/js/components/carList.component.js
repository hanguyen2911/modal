import React, { Component } from 'react';
import { Table,Button } from 'reactstrap';
import axios from 'axios';
import Addcar from './addCar.components'
class CarList extends Component {
    constructor(props){
        super(props);    
        this.state={
            cars:[],
            noDataFound:[],
            newModalCar:false,
        }
    }

    componentDidMount(){
        this.getCar();
    }

    getCar(){
        axios.get("http://localhost:8000/api/cars").then((response)=>
        {
            console.log(response.data.data);
            if(response.status === 200){
                this.setState({cars:response.data.data?response.data.data:[],});
            }if(response.data.status ==="failed" && response.data.success === "false"){
                this.setState({noDataFound:response.data.message,});
            }
        }).catch((error)=>{
            console.log(error);
        });
    }

    handleAddSubmit=(car)=>{
        console.log();
        const {cars}=this.state;
        cars.push(car);
        this.setState({cars:cars,})
    }
    toogleAddModal=()=>{
        this.setState({newModalCar:!this.state.newModalCar});
    }
    onCloseFormAdd=()=>{
        this.setState({newModalCar:false});
    }
    render() {
        const{cars,noDataFound,newModalCar}=this.state;
        var carDetail=[];
        if(cars.length){
            carDetail=cars.map((car,index)=>{
                return(
                        <tr key={car.id}>
                            <td>{car.id}</td>
                            <td>{car.description}</td>
                            <td>{car.model}</td>
                            <td>{car.produced_on}</td>
                            <td><img src={"/images/"+car.image} width= "200px"  height="150px"></img></td>
                            <td className="display=flex">
                                <Button className ="mr-3 btn btn-success" size="sm">Edit</Button>
                                <Button className="sm btn btn-danger" size="sm">Delete</Button>
                            </td>
                        </tr>
                
                );
            });
        }
        return (
            <div>
                <h2>List of car</h2>
            <Addcar newModalCar = {newModalCar} toogleAddModal = {this.toogleAddModal} onCloseForm={this.onCloseForm} handleAddSubmit={this.handleAddSubmit}/>
            <Table>
                <thead>
                    <tr className="text-primary">
                        <th>ID</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>Produced_on</th>
                        <th>image</th>
                        <th>Function</th>
                    </tr>
                </thead>
                {cars.length === 0 ?
                (<tbody><tr><td><h2></h2></td></tr></tbody>):
                (<tbody>{carDetail}</tbody>)}
            </Table>
            </div>
        );
    }
}

export default CarList;