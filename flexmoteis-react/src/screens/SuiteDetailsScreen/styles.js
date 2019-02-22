import { StyleSheet } from 'react-native'
const styles = StyleSheet.create({
    wrapperContainer: {
        flex: 1,
        backgroundColor: '#fff',
    },
    titleContainer: { 
        width: '100%', 
        height: 70, 
        position: 'absolute', 
        backgroundColor: 'transparent' 
    },
    titleWrapperContainer: { 
        flexDirection: 'row', 
        justifyContent: 'center', 
        alignItems: 'center', 
        flex: 1, 
        backgroundColor: 'transparent' 
    },
    backButton: {
        left: 20, 
        position: 'absolute',
    }, 
    favoriteButton: {
        right: 20,
        position: 'absolute'
    },
    slideIcon: { 
        padding: 5, 
    },
    title: { 
        color: '#fff', 
        fontWeight: 'bold', 
        fontSize: 20 
    }
})
export default styles