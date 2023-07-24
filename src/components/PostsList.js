import React, { useEffect } from 'react';
import PostComponent from "./PostComponent";
import styles from "../style/imageStyle.module.css";


const PostsList = ({visiblePosts }) => {
    const imagePosts = visiblePosts.map((post, key) => {
        return (
            <PostComponent post={post} key={key}/>
        );
    })

    return (
        <div className={`container-fluid p-4 p-md-5 my-5 ${styles.imageContainer}`} id={'grid-posts'}>
            <div className={`mx-auto px-lg-5 pt-sm-3 ${styles.maxWidth}`}>
                <div className={'row gx-3 gy-4 gx-md-4 gy-md-5 g-lg-4 g-xxl-5 mt-md-1 mt-lg-2 mt-xl-4'}>
                    {imagePosts}
                </div>
            </div>
        </div>
    )
}

export default PostsList;
