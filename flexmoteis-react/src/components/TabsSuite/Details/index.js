import React, { Component } from 'react'
import { View, Text } from 'react-native'
import styles from './styles'
import IonIcons from 'react-native-vector-icons/Ionicons'
import Icon from 'react-native-vector-icons/FontAwesome'
import uiTheme from '../../../assets/uiTheme'


export default Details = () => {
    return (
        <View style={ styles.container }>
            <View style={ styles.apresentation }>
                <Text style={{ fontWeight: 'bold', color: uiTheme.palette.primaryTextColor, marginBottom: 10 }}>Instalações</Text>
                <Text style={{ lineHeight: 20, color: '#8b8b8b' }}>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel ipsum cursus, convallis ipsum at, congue ligula. Nunc dignissim.</Text>
                <View style={{ position: 'absolute', right: 15, bottom: 20 }}>
                    <Text style={{ color: uiTheme.palette.primaryTextColor, fontWeight: 'bold' }}>Ler mais</Text>
                </View>
            </View>
            <View style={ styles.installationsContainer }>
                <View style={ styles.installationsRow }>
                    <View style={ styles.installationItem }>
                        <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                        <Text style={{ color: uiTheme.palette.primaryTextColor }}>Wifi</Text>
                    </View>
                    <View style={ styles.installationItem }>
                        <IonIcons name="md-tv" color="#757575" size={ 25 } />
                        <Text style={{ color: '#757575' }}>TV a cabo</Text>
                    </View>
                    <View style={ styles.installationItem }>
                        <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                        <Text style={{ color: uiTheme.palette.primaryTextColor }} >Wifi</Text>
                    </View>
                </View>
                <View style={ styles.installationsRow }>
                    <View style={ styles.installationItem }>
                        <IonIcons name="md-tv" color="#757575" size={ 25 } />
                        <Text style={{ color: '#757575' }}>TV a cabo</Text>
                    </View>
                    <View style={ styles.installationItem }>
                        <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                        <Text style={{ color: uiTheme.palette.primaryTextColor }} >Wifi</Text>
                    </View>
                    <View style={ styles.installationItem }>
                        <IonIcons name="md-tv" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                        <Text style={{ color: uiTheme.palette.primaryTextColor }}>TV a cabo</Text>
                    </View>
                </View>
                <View style={ styles.installationsRow }>
                    <View style={ styles.installationItem }>
                        <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                        <Text style={{ color: uiTheme.palette.primaryTextColor }} >Wifi</Text>
                    </View>
                    <View style={ styles.installationItem }>
                        <IonIcons name="md-tv" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                        <Text style={{ color: uiTheme.palette.primaryTextColor }}>TV a cabo</Text>
                    </View>
                    <View style={ styles.installationItem }>
                        <Icon name="wifi" color={ uiTheme.palette.primaryTextColor } size={ 25 } />
                        <Text style={{ color: uiTheme.palette.primaryTextColor }} >Wifi</Text>
                    </View>
                </View>
            </View>
        </View>
    )
}