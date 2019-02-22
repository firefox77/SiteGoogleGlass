import React, { Component } from 'react'
import { Text, TouchableOpacity, View } from 'react-native';
import DateTimePicker from 'react-native-modal-datetime-picker';
import Ionicons from 'react-native-vector-icons/Ionicons'
import styles from './styles'

class CalendarComponent extends Component {
    state = {
        date: '01/01/2019',
        time: '10:30',
        isDatePickerVisible: false,
        isTimePickerVisible: false,
    };

    hideDatePicker = () => this.setState({ isDatePickerVisible: false });
    hideTimePicker = () => this.setState({ isTimePickerVisible: false });

    handleDatePicked = date => {
        const day = (date.getDate() < 10 ? '0' : '') + String(date.getDate()) 
        const month = ((date.getMonth() + 1) < 10 ? '0' : '') + String(date.getMonth() + 1) 
        const year = String(date.getFullYear()) 
        const newDate = day + '/' + month + '/' + year
        this.setState({ date: newDate })
        this.hideDatePicker();
    };
    handleTimePicked = date => {
        const hours = (date.getHours() < 10 ? '0' : '') + String(date.getHours())
        const minutes = (date.getMinutes() < 10 ? '0' : '') + String(date.getMinutes())
        const newTime = hours + ':' + minutes
        this.setState({ time: newTime })
        this.hideTimePicker();
    };
    render() {
        const { date, time } = this.state
        return (
            <View style={ styles.container }>
                <View style={ styles.calendarContainer }>
                    <View style={ styles.calendar }>
                        <TouchableOpacity style={ styles.button } onPress={() => this.setState({ isDatePickerVisible: true })}>
                            <Ionicons name="md-calendar" color="#fff" size={ 20 } />
                        </TouchableOpacity>
                        <View style={ styles.content }>
                            <Text style={ styles.textContent }>{ date }</Text>
                        </View>
                    </View>
                    <View style={ styles.calendar }>
                        <TouchableOpacity style={ styles.button } onPress={() => this.setState({ isTimePickerVisible: true })}>
                            <Ionicons name="md-time" color="#fff" size={ 20 } />
                        </TouchableOpacity>
                        <View style={ styles.content }>
                            <Text style={ styles.textContent }>{ time }</Text>
                        </View>
                    </View>
                </View>
                <View style={ styles.warningContainer }>
                    <Text style={ styles.warningText }>Altere data e horário para atualizar os valores</Text>
                </View>
                <DateTimePicker
                    isVisible={ this.state.isDatePickerVisible }
                    onConfirm={ this.handleDatePicked }
                    onCancel={ this.hideDatePicker }
                    mode="date"
                />
                <DateTimePicker
                    isVisible={ this.state.isTimePickerVisible }
                    onConfirm={ this.handleTimePicked }
                    onCancel={ this.hideTimePicker }
                    mode="time"
                />
            </View>
        )
    }
}
export default CalendarComponent
