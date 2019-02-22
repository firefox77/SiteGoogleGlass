import React from 'react'
import { View, Text, TouchableOpacity } from 'react-native'
import styles from './styles'
import Calendar from '../../Calendar'

export default Details = () => {
    return (
        <View style={ styles.container }>
            <Calendar />
            <View style={ styles.priceContainer }>
                <View style={ styles.priceBox }>
                    <View style={ styles.bodyBox }>
                        <Text style={ styles.text }>Sábado - Manhã e Tarde</Text>
                        <View style={ styles.additionalInfoContainer }>
                            <Text style={ styles.additionalInfoText }>Lorem ipsum dolor sit amet, consecte tur adipiscing elit. Proin.</Text>
                        </View>
                    </View>
                    <View style={ styles.price }>
                        <Text style={ styles.text }>R$ 329,99</Text>
                    </View>
                </View>
            </View>
            <View style={ styles.priceContainer }>
                <View style={ styles.priceBox }>
                    <View style={ styles.bodyBox }>
                        <Text style={ styles.text }>Sábado - Manhã e Tarde</Text>
                        <View style={ styles.additionalInfoContainer }>
                            <Text style={ styles.additionalInfoText }>Lorem ipsum dolor sit amet, consecte tur adipiscing elit. Proin.</Text>
                        </View>
                    </View>
                    <View style={ styles.price }>
                        <Text style={ styles.text }>R$ 329,99</Text>
                    </View>
                </View>
            </View>
        </View>
    )
}