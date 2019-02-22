import { StyleSheet, Dimensions } from 'react-native'
import uiTheme from '../../assets/uiTheme'

const { width } = Dimensions.get('window')
const styles = StyleSheet.create({
    container: { 
        marginVertical: 20, 
        marginHorizontal: 10, 
        backgroundColor: '#fff' 
    },
    calendarContainer: { 
        flexDirection: 'row', 
        justifyContent: 'space-around' 
    },
    calendar: { 
        flexDirection: 'row', 
        justifyContent: 'center' 
    },
    button: { 
        width: 35, 
        height: 35, 
        backgroundColor: uiTheme.palette.primaryTextColor, 
        justifyContent: "center", 
        alignItems: "center" 
    },
    content: {
        height: 35, 
        alignItems: "center", 
        justifyContent: 'center', 
        width: 100, 
        borderColor: '#ddd', 
        borderWidth: 1, 
        backgroundColor: '#fff'
    },
    textContent: { 
        color: uiTheme.palette.grayTextColor 
    },
    warningContainer: { 
        alignItems: 'center', 
        marginVertical: 10 
    },
    warningText: { 
        fontSize: 12, 
        color: uiTheme.palette.grayTextColor 
    }
})

export default styles