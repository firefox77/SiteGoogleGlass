import React, { Component } from 'React'
import { View, Text, Image, ScrollView, TouchableOpacity } from 'react-native'
import TimelineList from 'react-native-timeline-feed'
import styles from './styles'
import NavBottom from '../../components/NavBottom'
import Icon from 'react-native-vector-icons/MaterialCommunityIcons'


export default class TimelineScreen extends Component {
    constructor(){
        super()

       
        const NewIconMinus = (props) => <Icon name="minus" size={22} color="white" {...props} />;
        const NewIconPlus = (props) => <Icon name="plus" size={22} color="white" {...props} />;
      

        this.data = [{key:'1',time: '03:00', title: '11/01/2019 - Débito', motolecas:'-1.4', description: 'Vitara Motel',icon: NewIconMinus,circleColor:'rgb(255,0,0)'},
        {key:'2', time: '02:45', title: '11/01/2019 - Débito', motolecas:'-1.4', description: 'Vitara Motel',icon:NewIconMinus, circleColor:'rgb(255,0,0)'},
        {key:'3', time: '12:00', title: '10/01/2019 - Crédito', motolecas:'10.000', description: 'Vitara Motel',icon:NewIconPlus,circleColor:'rgb(0,255,0)'},
        {key:'4', time: '14:00', title: '10/01/2019 - Débito', motolecas:'-1.4', description: 'Vitara Motel',icon: NewIconMinus,circleColor:'rgb(255,0,0)'},
        {key:'5', time: '16:30', title: '10/01/2019 - Débito', motolecas:'-1.4', description: 'Vitara Motel',icon: NewIconMinus,circleColor:'rgb(255,0,0)'},
        {key:'6', time: '17:30', title: '10/01/2019 - Crédito', motolecas:'10.000', description: 'Vitara Motel',icon:NewIconPlus,circleColor:'rgb(0,255,0)'},
        {key:'7', time: '18:00', title: '10/07/2018 - Crédito', motolecas:'10.000', description: 'Vitara Motel',icon:NewIconPlus,circleColor:'rgb(0,255,0)'},
        {key:'8', time: '18:10', title: '10/07/2018 - Crédito', motolecas:'10.000', description: 'Vitara Motel',icon:NewIconPlus,circleColor:'rgb(0,255,0)'},
        
        ]
        
    }

    renderDetail = ({ item }) => {     
        return (
            <View key={ item.key } style={{ flex: 1, borderColor: '#ddd', borderBottomWidth: 1 }}>                
                <View style={{ height: 70, flexDirection: 'row' }}>
                    <View style={{ height: 50,  flex: 1 }}>
                        <Text style={{ fontWeight: 'bold' }}>{ item.title }</Text>
                        <View style={{ flexDirection: 'row' }}>
                            <View style={{flex:1}}>
                                <Text style={styles.info} >Origem:</Text>
                            </View>
                            <View style={{flex:2}}>
                                <Text style={styles.info} >{ item.description }</Text>
                            </View>
                        </View>
                        <View  style={{ flexDirection: 'row' }}>
                            <View style={{flex:2}}>
                                <Text style={styles.info} >Motelecas:</Text>
                            </View>
                            <View style={{flex:2}}>
                                <Text style={styles.info}>{ item.motolecas }</Text>
                            </View>
                        </View>
                    </View> 
                </View>
            </View>
        );   
    }

    
    render() {
        
        return (
            <View style={{ flex: 1 }}>
                <ScrollView style={ [{flex: 1}, styles.container] }>
                    <View style={ styles.containerTimeline }>
                        <TimelineList
                            keyExtractor={ (item) => item.key }
                            data={ this.data }
                            renderDetail={ this.renderDetail }
                            innerCircleType='icon'
                            circleSize={ 24 }
                            lineColor='rgb(45,156,219)'
                            timeContainerStyle={ styles.timeContainer }
                            timeStyle={ styles.time }
                            descriptionStyle={ styles.description }
                            style={ styles.timeline }
                        />
                    </View>
                </ScrollView>
            </View>
           
        )
    }
}