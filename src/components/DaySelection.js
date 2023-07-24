import React, {useState, useEffect} from 'react';
import buttonStyles from '../style/buttons.module.css';
import styles from "../style/homePage.module.css";

let defaultActiveButtonClass = '';
let i=0;

const DaySelection = (props) => {
    let posts = props.posts;
    let setSelectedDay = props.setSelectedDay;

    const handleSelectedButtonClick = (index) => {
        setSelectedDay(index);


        defaultActiveButtonClass = '';
        document.getElementById(`button-${index}`).className = "button";



        if(document.getElementsByClassName("active").length>0) {
            document.getElementsByClassName("active")[0].className = "button";
        }

        document.getElementById(`button-${index}`).className= "button active";


    }

    const dateButtons = Object.keys(posts).map((date, index) => {
        i++

        if ((Object.keys(posts).length)===i) {
            defaultActiveButtonClass = `${buttonStyles.button} ${buttonStyles.active}`;
        }

        return (
            <li key={index+1}>
                <button type={'button'} onClick={() => {handleSelectedButtonClick(index+1)}} id={`button-${index+1}`} className={`${buttonStyles.button} ${defaultActiveButtonClass}`}>dag {index+1}</button>
            </li>)
    });

    return (
        <div className={styles.navButtonsWrapper}>
            {/*<img src={'./images/nav-frame-left.svg'} alt={"frame outline"} className={styles.navFrame}/>
            <ul className={styles.buttonContainer}>
                {dateButtons}
            </ul>
            <img src={'./images/nav-frame-right.svg'} alt={"frame outline"} className={styles.navFrame}/>*/}
            <img src={'./images/logo.svg'} alt={'webatvantage logo'} className={styles.navLogo}/>
        </div>
    )
}

export default DaySelection
