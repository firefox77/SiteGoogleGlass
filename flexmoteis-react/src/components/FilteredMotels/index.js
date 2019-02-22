import React, { Component } from 'react'
import { Text, View, FlatList, Image, TouchableNativeFeedback } from 'react-native'
import styles from './styles'
import { Rating } from 'react-native-elements'
import IonIcons from 'react-native-vector-icons/Ionicons'
import uiTheme from '../../assets/uiTheme';

class FilteredMotels extends Component {
    renderMotel = motel => {
        return (
            <View style={ styles.card }>
            <TouchableNativeFeedback onPress={() => { this.props.navigation.navigate('MotelDetailsScreen') }}>
                <View style={{ flex: 1 }}>
                    <Image style={ styles.image } resizeMode="cover" source={{uri: 'https://www.flexmoteis.com.br/wp-content/uploads/2015/11/73b3f92f2f96a977f87b41d78caf5062.jpg'}} />
                    <View style={ styles.captionContainer }>
                        <View style={ styles.captionWrapperContainer }>
                            <View>
                                <Text style={ styles.captionBold }>Nome do Motel</Text>
                            </View>
                            <View style={ styles.ratingContainer }>
                                <Rating
                                    type="custom"
                                    ratingColor={ uiTheme.palette.primaryTextColor }
                                    imageSize={12}
                                    readonly
                                    startingValue={4}
                                    style={ styles.rating }
                                />
                            </View>
                        </View>
                        <View style={ styles.captionWrapperContainer }>
                            <View style={{ flexDirection: 'row' }}>
                                <IonIcons 
                                    style={{ right: 5, top: 5 }}
                                    name="md-pin"
                                    color={ uiTheme.palette.grayTextColor }
                                    size={ 12 }
                                />
                                <Text style={ styles.grayText }>6.3 KM do centro</Text>
                            </View>
                            <View style={{ position: 'absolute', right: 10 }}>
                                <Text style={ styles.grayText }>344 Visualizações</Text>
                            </View>
                        </View>
                        <View style={ styles.captionWrapperContainer }>
                            <View>
                                <Text style={ styles.captionBold }>R$ 89,90</Text>
                            </View>
                            <View style={ styles.ratingStatus }>
                                <Text style={ styles.grayText }>Excelente</Text>
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
            <View style={{ flex: 1, marginTop: 20 }}>
                <View style={{ flexDirection: 'row' }}>
                    <FlatList
                        showsHorizontalScrollIndicator={ false }
                        data={ this.props.filteredMotels }
                        keyExtractor={ item => item.id }
                        renderItem={ this.renderMotel }
                    />
                </View>
            </View>
        );
    }    
}

export default FilteredMotels;
