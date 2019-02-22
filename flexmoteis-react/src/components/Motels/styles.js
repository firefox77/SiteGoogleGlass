import React from 'react'
import { StyleSheet, Dimensions } from 'react-native'
import uiTheme from '../../assets/uiTheme'

const { width } = Dimensions.get('window')
const styles = StyleSheet.create({
    container: {
        flex: 1,
        position: 'absolute',
        top: 60
    },
    captionContainer: { 
        flex: 1, 
        paddingVertical: 15,
    },
    captionWrapperContainer: { 
        flex: 1, 
        justifyContent: 'center', 
        alignItems: 'center' 
    },
    priceContainer: { 
        flex: 1, 
        padding: 5 
    },
    priceWrapperContainer: { 
        flex: 1, 
        flexDirection: 'row', 
        justifyContent: 'center', 
        alignItems: 'center' 
    },
    hoursText: { 
        color: '#ff7800', 
        marginRight: 15 
    },
    priceText: { 
        color: '#006800', 
        marginLeft: 15 
    },
    motelContainer: { 
        flex: 1, 
        flexDirection: 'row', 
        height: 80,  
        marginTop: 20 
    },
    motelWrapperContainer: { 
        width: 100, 
        justifyContent: 'center', 
        alignItems: 'center' 
    },
    motelName: { 
        color: uiTheme.palette.primaryTextColor, 
        fontSize: 18, 
        fontWeight: 'bold'
    },
    motelAddress: { 
        color: uiTheme.palette.grayTextColor, 
        fontSize: 12 
    },
    motelCaptionIcon: { 
        marginRight: 3, 
        marginTop: 1 
    },
    captionText: { 
        color: uiTheme.palette.primaryTextColor, 
        fontSize: 10
    },
    suiteName: { 
        color: '#FFF', 
        fontWeight: 'bold',
        position:"absolute",
        bottom:0,
        textAlign:"center",
        width:"100%",
        paddingVertical:16,
        paddingHorizontal: 8,
        backgroundColor: 'rgba(0,0,0, 0.5)',
        borderBottomLeftRadius: 20,
        borderBottomRightRadius: 20,
        textShadowColor: '#000',
        textShadowOffset:{width:1,height:1},
        textShadowRadius: 10
    },
    iconBox: { 
        width: 18, 
        height: 18, 
        justifyContent: 'center', 
        alignItems: 'center', 
        marginHorizontal: 5 
    },
    card: {
        flex: 1,
        width: width - 60,
        marginTop: 5,
        marginLeft: 20,
        backgroundColor: '#fff',
    },
    image: {
        borderRadius: 20,
        height: 200,
        width: '100%'
    },
    motelImage: {
        borderRadius: 60,
        height: 60,
        width: 60
    },
});

export default styles