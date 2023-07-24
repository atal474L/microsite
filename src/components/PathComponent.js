import React from 'react';
import styles from '../style/imageStyle.module.css'

import Frame01 from "./Frame01";
import Frame02 from "./Frame02";
import Frame03 from "./Frame03";
import Frame04 from "./Frame04";
import Frame05 from "./Frame05";
import Frame06 from "./Frame06";


const PathComponent = (props) => {
    let renderedFrame;
    switch (props.clipFrameNumber) {
        case 1:
            renderedFrame = <Frame01 url={props.imageURL}/>;
            break;
        case 2:
            renderedFrame = <Frame02 url={props.imageURL} />;
            break;
        case 3:
            renderedFrame = <Frame03 url={props.imageURL} />;
            break;
        case 4:
            renderedFrame = <Frame04 url={props.imageURL} />;
            break;
        case 5:
            renderedFrame = <Frame05 url={props.imageURL} />;
            break;
        case 6:
            renderedFrame = <Frame06 url={props.imageURL} />;
            break;
    }

    return (<>
        {renderedFrame}
        </>
    );
}

export default PathComponent;
