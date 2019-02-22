import React from 'react'
import { COLOR } from 'react-native-material-ui'
const uiTheme = {
    palette: {
        primaryColor: COLOR.gray,
        primaryTextColor: COLOR.purple500,
        secondaryTextColor: COLOR.black,
        grayTextColor: '#949192',
        grayBackground: '#e7e7e7'
    },
    bottomNavigation: {
        container: {
            backgroundColor: COLOR.purple500
        },
    },
    toolbar: {
        container: {
            backgroundColor: COLOR.purple500,
        },
    },
    actionButton: {
        container: {
            backgroundColor: COLOR.purple500,
            bottom: 50
        }
    }
};

export default uiTheme
