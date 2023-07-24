import React, { useState } from "react";
import PostsList from '../components/PostsList.js'
import '../style/font.css';
import temperatureStyles from "../style/temperature.module.css";
import styles from '../style/homePage.module.css'
import DubaiIntro from '../components/IntroAnimation'
import DaySelection from '../components/DaySelection'

let oneSinglePost;

let visiblePosts = [];
//
const extractImagesFromData = (postsSelectedDay) => {
    //verwijder alle eerdere afbeeldingen, zodanig
    //loop alle posts per dag, en haal er de links naar alle afbeeldingen uit
    //push die in de array "images from all days", die we later gebruiken om alle afbeeldingen weer te kunnen geven
    for (let i = 0; i < (postsSelectedDay.length); i++) {
        oneSinglePost = Object.values(postsSelectedDay)[i];

        visiblePosts.push(oneSinglePost);
    }
}

const getSelectedDayPosts = (postsAllDays, selectedDay) => {
    postsAllDays.map((i) => {
        extractImagesFromData(i)
    })
}

const HomePage = ({ posts, temperature}) => {
    let temperatureValue;
    let [selectedDay, setSelectedDay] = useState(Object.keys(posts).length);

    const postsAllDays = Object.values(posts);
    //haal de datums uit de data
    //extractDatesFromData(postsAllDays);
    getSelectedDayPosts(postsAllDays, selectedDay);

    if (temperature) {
        temperatureValue = `${temperature}°c`;
    } else {
        temperatureValue = '';
    }

    //get time
    // create Date object for current location
    let date = new Date();

// convert to milliseconds, add local time zone offset and get UTC time in milliseconds
    let utcTime = date.getTime() + (date.getTimezoneOffset() * 60000);

// time offset for Dubai is 4
    const timeOffset = 4;

// create new Date object for a different timezone using supplied its GMT offset.
    let dubaiTime = new Date(utcTime + (3600000 * timeOffset));
    let dubaiTimeHour = dubaiTime.getHours();
    let dubaiTimeMinutes = dubaiTime.getMinutes();

    let timeImage = './images/time-sun.svg';

    if (dubaiTimeHour>19 || dubaiTimeHour<6) {
       timeImage = '/images/time-moon.svg';
    }

    if (`${dubaiTimeMinutes}`.length<=1) {
        dubaiTimeMinutes=`0${dubaiTimeMinutes}`
    }

   let timeValue= `${dubaiTimeHour}:${dubaiTimeMinutes}`;

    return (
        <>
            <div className={styles.navTopGradient}>
            </div>
            <nav>
                <div className={`${temperatureStyles.temp}`}>
                    <img src={'./images/barometer.svg'} alt={"barometer"} />
                    <p>{temperatureValue}</p>
                </div>

                <DaySelection posts={posts} selectedDay={selectedDay} setSelectedDay={setSelectedDay}/>


                <div className={temperatureStyles.time}>
                    <img src={timeImage} alt={"barometer"} />
                    <p>{timeValue}</p>
                </div>

            </nav>
            <div>
                <PostsList visiblePosts={visiblePosts}/>
            </div>
            <div>
                <DubaiIntro/>
            </div>
            <div className={styles.navBottomGradient}>
            </div>
        </>
    );
}

export default HomePage;
