import React, { Component } from 'react'
import { View, Image, Dimensions } from 'react-native'
import Swiper from 'react-native-swiper'
import styles from './styles'

const Slider = props => (
    <View style={ styles.container }>
        <Image source={ props.uri } imageStyle={{ resizeMode: 'stretch' }} style={ styles.image } />
    </View>
)

export default class extends Component {
    constructor( props ) {
        super( props )
        this.state = {
            imageSlider: [
                require('./images/um.jpg'),
                require('./images/dois.jpg'),
                require('./images/tres.jpg')
            ]
        }
    }

    render() {
        return (
            <View style={{ height: 200 }}>
                <Swiper 
                    autoplay 
                    dotStyle={{ backgroundColor: 'transparent', borderColor: '#fff', borderWidth: 1 }}
                    activeDotStyle={{ backgroundColor: '#fff' }}
                >
                    {
                        this.state.imageSlider.map(( item, i ) => <Slider uri = { item } key = { i }/>)
                    }
                </Swiper>
            </View>
        )
    }
}