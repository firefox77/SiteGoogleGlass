import React from 'react'
import { View, Text } from 'react-native'
import styles from './styles'
import { Circle as CircleProgress } from 'react-native-progress';

export default Details = props => {
    return (
        <View style={ styles.container }>
            <View style={ styles.ratingContainer }>
                <View style={{ width: 120 }}>
                    <CircleProgress
                        style={styles.circleProgress}
                        progress={ 0.7 } 
                        showsText={true}
                    />
                </View>
                <View style={ styles.ratingBox }>
                    <Text style={ styles.pontuationText }>70/100</Text>
                    <Text style={ styles.statusText }>Status da Avaliação - Bom</Text>
                    <Text style={ styles.totalRating }>Total de 210 avaliações</Text>
                </View>
            </View>
            <View style={ styles.ratedItem }>
                <View style={{ flexDirection: 'row' }}>
                    <Text style={ styles.title }>I felt like a king</Text>
                    <Text style={ styles.percentage }>89%</Text>
                </View>
                <Text>Very excellent service. The house... Very excellent service. The house... </Text>
            </View>
            <View style={ styles.ratedItem }>
                <View style={{ flexDirection: 'row' }}>
                    <Text style={ styles.title }>I felt like a king</Text>
                    <Text style={ styles.percentage }>89%</Text>
                </View>
                <Text>Very excellent service. The house... Very excellent service. The house... </Text>
            </View>
        </View>
    )
}