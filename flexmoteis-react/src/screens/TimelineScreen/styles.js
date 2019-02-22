import { StyleSheet, Dimensions } from 'react-native'
const deviceWidth = Dimensions.get('window')
export default styles = StyleSheet.create({
    containerTimeline: {
        flex: 1,
        marginHorizontal: 20,
        marginTop: 20
    },
    timeline: {
        backgroundColor: '#fff'
    },
    time: {
        textAlign: 'center',
        backgroundColor:'#3c8dbc', 
        color:'white', 
        padding:5, 
        borderRadius:13
    },
    timeContainer: {
        minWidth:52, 
        marginTop: -5, 
        zIndex: 10
    },
    description: { 
        color:'gray',
    },
    iconWithText: {
        padding: 5
    },

    // HEADER
    container: {
        backgroundColor: '#fff'
    },
    info:{
        justifyContent: 'center',
    }

})
