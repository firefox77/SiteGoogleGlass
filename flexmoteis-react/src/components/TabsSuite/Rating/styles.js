import { StyleSheet, Dimensions } from 'react-native'
import uiTheme from '../../../assets/uiTheme'

const { width } = Dimensions.get('window')
const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#fff',
        marginHorizontal: 20, 
        marginTop: 20
    },
    ratingContainer: { 
        height: 120, 
        flexDirection: 'row', 
        borderBottomWidth: 1, 
        borderBottomColor: '#ddd' 
    },
    ratingBox: { 
        flex: 1, 
        backgroundColor: uiTheme.palette.primaryTextColor, 
        height: 100, 
        justifyContent: 'center', 
        alignItems: 'center' 
    },
    pontuationText: { 
        fontWeight: 'bold', 
        color: '#fff', 
        marginBottom: 5, 
        fontSize: 18 
    },
    statusText: { 
        color: '#fff' 
    },
    totalRating: { 
        color: '#fff', 
        fontSize: 12 
    },
    title: { 
        fontWeight: 'bold', 
        color: '#000', 
        marginBottom: 5 
    },
    percentage: { 
        color: uiTheme.palette.primaryTextColor, 
        right: 20, 
        position: 'absolute' 
    },
    ratedItem: { 
        height: 'auto',
        flex: 1,
        backgroundColor: '#fff',
        paddingVertical: 15,
        width: width - 20,
        marginTop: 5,
        marginBottom: 0,
        borderBottomWidth: 1,
        borderBottomColor: '#ddd',
    },
    circleProgress: {
        padding: 20,
        paddingLeft: 10,
        paddingTop: 10,
    }

})
export default styles