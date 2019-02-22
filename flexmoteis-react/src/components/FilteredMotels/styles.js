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
        paddingVertical: 15 
    },
    captionWrapperContainer: {
        flex: 1, 
        flexDirection: 'row', 
        alignItems: 'center', 
        paddingHorizontal: 10 
    },
    ratingContainer: { 
        position: 'absolute', 
        right: 10 
    },
    captionBold: { 
        color: '#800080', 
        fontWeight: 'bold' 
    },
    card: {
        flex: 1,
        height: 250,
        width: width - 40,
        marginVertical: 10,
        marginHorizontal: 20,
        backgroundColor: '#fff',
        borderTopLeftRadius: 5,
        borderTopRightRadius: 5,
        borderBottomWidth: 1,
        borderColor: '#ddd',
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.8,
        elevation: 1,
    },
    image: {
        borderTopLeftRadius: 5,
        borderTopRightRadius: 5,
        height: 150,
        width: '100%'
    },
    grayText: {
        color: uiTheme.palette.grayTextColor
    },
    ratingStatus: { 
        position: 'absolute', 
        right: 10 
    }
});

export default styles