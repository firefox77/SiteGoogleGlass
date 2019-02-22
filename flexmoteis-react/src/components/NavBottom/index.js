import React, { Component } from 'react';
import { View, StyleSheet,Image } from 'react-native';
import { PropTypes } from 'prop-types';
import { ThemeContext, getTheme, COLOR} from 'react-native-material-ui'
import BottomNavigation, {
    Badge,
    ShiftingTab
  } from 'react-native-material-bottom-navigation'
import Icon from 'react-native-vector-icons/MaterialCommunityIcons'

import uiTheme from '../../assets/uiTheme'

export default class NavBottom extends React.Component {
    tabs = [
        {
            isActive: false,
            key: 'reservas',
            icon: 'calendar-heart',
            label: 'Reservas',
            barColor: COLOR.purple400,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        },
        {
            isActive: false,
            key: 'motelecas',
            icon: 'heart',
            label: 'Favoritos',
            barColor: COLOR.purple500,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        },
        {
            isActive: true,
            key: 'home',
            icon: 'home',
            label: 'Motéis',
            barColor: COLOR.purple400,
            pressColor: 'rgba(255, 255, 255, 0.16)'
          },
        {
            isActive: false,
            key: 'descontos',
            icon: 'tag-multiple',
            label: 'Descontos',
            barColor: COLOR.purple500,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        },
        {
            isActive: false,
            key: 'extratos',
            icon: 'calculator',
            label: 'Extratos',
            barColor: COLOR.purple400,
            pressColor: 'rgba(255, 255, 255, 0.16)'
        }
    ]

    componentWillMount () {
        uiTheme.palette.secondaryTextColor = COLOR.white
        uiTheme.palette.primaryTextColor= COLOR.white
        uiTheme.palette.primaryColor= COLOR.white
        
    }

    renderIcon = iconName => ({ isActive }) => {
        return <Icon size={24} color="white" name={iconName} />
    }

    renderTab = ({ tab, isActive }) => (
        <ShiftingTab
            key={tab.key}
            isActive={tab.isActive}
            label={tab.label}
            renderIcon={this.renderIcon(tab.icon)}
            useLayoutAnimation
            />
    )

    tabPress = (newTab, oldTab) => {
        this.tabs[2].isActive = false;
        newTab.isActive = true;
        oldTab.isActive = false;
    }
    

    render() {
        
        return (
            <View>
                <BottomNavigation renderTab={this.renderTab} tabs={this.tabs} onTabPress={this.tabPress} />
            </View>
        );
    }
}

