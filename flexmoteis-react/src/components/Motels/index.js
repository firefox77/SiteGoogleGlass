import React, { Component } from 'react'
import { Text, View, FlatList, Image, TouchableNativeFeedback, TouchableWithoutFeedback } from 'react-native'
import styles from './styles'
import { Card, Button } from 'react-native-material-ui'
import uiTheme from '../../assets/uiTheme'
import Icon from 'react-native-vector-icons/MaterialCommunityIcons'
import FontAwesome5 from 'react-native-vector-icons/FontAwesome5'

export default class Motels extends Component {
    renderMotel = motel => {
        return (
            <View style={ styles.card }>
                <TouchableNativeFeedback onPress={() => this.props.navigation.navigate('SuiteDetailsScreen')}>
                    <View style={{ flex: 1 }}>
                        <View style={{position: "relative"}}>
                            <Image style={ styles.image } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/11/73b3f92f2f96a977f87b41d78caf5062.jpg'}} />
                            /*<Text style={styles.suiteName }>Suite Luxo com Hidro</Text>*/
                        </View>
                        
                        <View style={ styles.captionContainer }>
                            <View style={ styles.captionWrapperContainer }>
                                <View style={{ flexDirection: 'row' }}>
                                    <View style={ styles.iconBox }>
                                        <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 18 } />
                                    </View>
                                    <View style={ styles.iconBox }>
                                        <Icon name="television" color={ uiTheme.palette.primaryTextColor } size={ 18 } />
                                    </View>
                                    <View style={ styles.iconBox }>
                                        <Icon name="coffee" color={ uiTheme.palette.primaryTextColor } size={ 18 } />
                                    </View>
                                    <View style={ styles.iconBox }>
                                        <Icon name="car" color={ uiTheme.palette.primaryTextColor } size={ 18 } />
                                    </View>
                                </View>
                            </View>
                        </View>
                    </View>
                </TouchableNativeFeedback>
            </View>
        )   
    }
    render() {
        return (
            <View>
                <Card style={{ flex: 1 }}>
                    <View style={ styles.motelContainer }>
                        <View style={ styles.motelWrapperContainer }>
                            <TouchableNativeFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                                <Image style={ styles.motelImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/05/vitara4.jpg'}} />
                            </TouchableNativeFeedback>
                        </View>
                        <View style={{ flex: 1 }}>
                            <TouchableWithoutFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                                <Text style={ styles.motelName }>Vitara Motel</Text>
                            </TouchableWithoutFeedback>
                            <Text style={ styles.motelAddress }>Rod. Régis Bittencourt, km 271</Text>
                            <Text style={ styles.motelAddress }>Taboão da Serra - SP</Text>
                            <View style={{ flexDirection: 'row' }}>
                                <Icon 
                                    style={ styles.motelCaptionIcon }
                                    name="map-marker"
                                    color={ uiTheme.palette.primaryTextColor }
                                    size={ 10 }
                                />
                                <Text style={[ styles.captionText, { marginRight: 5 }]}>0.8 KM perto de você</Text>
                                <Icon 
                                    style={ styles.motelCaptionIcon }
                                    name="heart-multiple"
                                    color={ uiTheme.palette.primaryTextColor }
                                    size={ 10 }
                                />
                                <Text style={ styles.captionText }>Favorito de 12 mil pessoas</Text>
                            </View>
                        </View>
                    </View>
                    <View style={{ flexDirection: 'row' }}>
                        <FlatList
                            horizontal
                            showsHorizontalScrollIndicator={ false }
                            data={ this.props.motels }
                            keyExtractor={ item => item.id }
                            renderItem={ this.renderMotel }
                        />
                    </View> 
                    <View style={{flexDirection:'row'}}>
                        <Button flat primary text="Chame um Uber" icon={<FontAwesome5 name="uber"  style={{marginRight:5}} />} />
                        <Button flat primary text="Ir" icon={<Icon name="navigation" style={{marginRight:5}} />} />
                        <Button flat primary text="Convidar" icon={<FontAwesome5 name="kiss-wink-heart" style={{marginRight:5}} />} />
                        
                    </View>
                </Card>
                <Card style={{ flex: 1 }}>
                
                    <View style={ styles.motelContainer }>
                        <View style={ styles.motelWrapperContainer }>
                            <TouchableNativeFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                                <Image style={ styles.motelImage } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/05/bellelogo.jpg'}} />
                            </TouchableNativeFeedback>
                        </View>
                        <View style={{ flex: 1 }}>
                            <TouchableWithoutFeedback onPress={() => this.props.navigation.navigate('MotelDetailsScreen') }>
                                <Text style={ styles.motelName }>Motel Belle</Text>
                            </TouchableWithoutFeedback>
                            <Text style={ styles.motelAddress }>Rod. Raposo Tavares, KM 13</Text>
                            <Text style={ styles.motelAddress }>São Paulo</Text>
                            <View style={{ flexDirection: 'row' }}>
                                <Icon 
                                    style={ styles.motelCaptionIcon }
                                    name="map-marker"
                                    color={ uiTheme.palette.primaryTextColor }
                                    size={ 10 }
                                />
                                <Text style={[ styles.captionText, { marginRight: 5 }]}>3.8 KM perto de você</Text>
                                <Icon 
                                    style={ styles.motelCaptionIcon }
                                    name="heart-multiple"
                                    color={ uiTheme.palette.primaryTextColor }
                                    size={ 10 }
                                />
                                <Text style={ styles.captionText }>Favorito de 2 mil pessoas</Text>
                            </View>
                        </View>
                    </View>
                    <View style={{ flexDirection: 'row' }}>
                        <FlatList
                            horizontal
                            showsHorizontalScrollIndicator={ false }
                            data={ this.props.motels }
                            keyExtractor={ item => item.id }
                            renderItem={ this.renderMotel }
                        />
                    </View> 
                    <View style={{flexDirection:'row'}}>
                        <Button flat primary text="Chame um Uber" icon={<FontAwesome5 name="uber"  style={{marginRight:5}} />} />
                        <Button flat primary text="Ir" icon={<Icon name="navigation" style={{marginRight:5}} />} />
                        <Button flat primary text="Convidar" icon={<FontAwesome5 name="kiss-wink-heart" style={{marginRight:5}} />} />
                        
                    </View>
                </Card>
            </View>
        )
    }
}