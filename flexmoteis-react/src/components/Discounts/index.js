import React, { Component } from 'react'
import { View, Text, Image, TouchableNativeFeedback } from 'react-native'
import styles from './styles'
import Icon from 'react-native-vector-icons/FontAwesome'

export default class Reservatios extends Component {
    render() {
        return (
            <View style={ styles.container}>
                <View style={ styles.ticket }>
                    <View style={ styles.motelWrapperContainer }>
                        <TouchableNativeFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                            <Image style={ styles.motelImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/05/vitara4.jpg'}} />
                        </TouchableNativeFeedback>
                    </View> 
                    <View style={ styles.content }>
                        <View style={ styles.row }>    
                            <Text style={ styles.suiteName }>Luxo com estacionamento</Text>
                            <Text style={ styles.status }>Inativo</Text>
                        </View>
                        <View style={ styles.row }>    
                            <View style={ styles.code }>
                                <Icon name="ticket" size={ 15 } color="#ddd" style={ styles.icon } />
                                <Text style={ styles.inactiveText }>vitara10</Text>
                            </View>
                            <View style={ styles.infoContainer }>
                                <Text style={ styles.text }>18:00</Text>
                                <Text style={ styles.text }>15/02/2019</Text>
                            </View>
                        </View>
                    </View>
                </View>
               
                <View style={ styles.ticket }>
                    <View style={ styles.motelWrapperContainer }>
                        <TouchableNativeFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                            <Image style={ styles.motelImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/05/bellelogo.jpg'}} />
                        </TouchableNativeFeedback>
                    </View> 
                    <View style={ styles.content }>
                        <View style={ styles.row }>    
                            <Text style={ styles.suiteName }>Luxo com hidro</Text>
                            <Text style={ styles.status }>Ativo</Text>
                        </View>
                        <View style={ styles.row }>    
                            <View style={ styles.code }>
                                <Icon name="ticket" size={ 15 } color="#ddd" style={ styles.icon } />
                                <Text style={ styles.activeText }>belle10</Text>
                            </View>
                            <View style={ styles.infoContainer }>
                                <Text style={ styles.text }>18:00</Text>
                                <Text style={ styles.text }>15/02/2019</Text>
                            </View>
                        </View>
                    </View>
                </View>
                <View style={ styles.ticket }>
                    <View style={ styles.motelWrapperContainer }>
                        <TouchableNativeFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                            <Image style={ styles.motelImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/05/vitara4.jpg'}} />
                        </TouchableNativeFeedback>
                    </View> 
                    <View style={ styles.content }>
                        <View style={ styles.row }>    
                            <Text style={ styles.suiteName }>Luxo com estacionamento</Text>
                            <Text style={ styles.status }>Inativo</Text>
                        </View>
                        <View style={ styles.row }>    
                            <View style={ styles.code }>
                                <Icon name="ticket" size={ 15 } color="#ddd" style={ styles.icon } />
                                <Text style={ styles.inactiveText }>vitara10</Text>
                            </View>
                            <View style={ styles.infoContainer }>
                                <Text style={ styles.text }>18:00</Text>
                                <Text style={ styles.text }>15/02/2019</Text>
                            </View>
                        </View>
                    </View>
                </View>
               
                <View style={ styles.ticket }>
                    <View style={ styles.motelWrapperContainer }>
                        <TouchableNativeFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                            <Image style={ styles.motelImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/05/bellelogo.jpg'}} />
                        </TouchableNativeFeedback>
                    </View> 
                    <View style={ styles.content }>
                        <View style={ styles.row }>    
                            <Text style={ styles.suiteName }>Luxo com hidro</Text>
                            <Text style={ styles.status }>Ativo</Text>
                        </View>
                        <View style={ styles.row }>    
                            <View style={ styles.code }>
                                <Icon name="ticket" size={ 15 } color="#ddd" style={ styles.icon } />
                                <Text style={ styles.activeText }>belle10</Text>
                            </View>
                            <View style={ styles.infoContainer }>
                                <Text style={ styles.text }>18:00</Text>
                                <Text style={ styles.text }>15/02/2019</Text>
                            </View>
                        </View>
                    </View>
                </View>
            </View>
        )
    }
}