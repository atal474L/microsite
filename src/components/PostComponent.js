import React from 'react'
import styles from "../style/imageStyle.module.css";

const PostComponent = (props) => {
    let i = props.id;

    // exit fn if post is not found (temp ignore non-photos)
    if (!props.post || props.post?.type === 'VIDEO') return (<></>);

    const caption = props.post?.caption ?? '';
    const author = props.post?.author ?? '';
    const time = props.post?.time ?? '';
    let dateConverted = '';


    try {
        const postedAt = props.post.posted_at.split('T');
        const date = postedAt[0];
        dateConverted = date.split('-').reverse().join('/');
    } catch (e) {
        console.error(e.message);
    }

    // determine type, if no type s defined treat is as an image
    // const isImage = props.post?.type === 'PHOTO' ?? 'PHOTO';


    const renderPost = () => {
        // if (isImage) {
        // get first image
        const image = props.post?.photos[0]?.url ?? '';


        return (
            <img src={image}
                 alt={`image-${i}`}
                 className={`p-3 img-fluid ${styles.ratio} ${styles.filter}`}
                 width={'600'}
                 height={'600'}
                 loading={'lazy'}
            />
        )
        // } else {
        //     return (
        //         <video src={}>
        //     )
        // }
    }


    // let values = Object.values(allPosts)[i];
    // console.log(values);
    // console.log(values?.author ?? '');

    return (
        <div className={`col-sm-6 col-lg-4 col-xxl-3 col-image`} key={`image-${i}`}>
            <figure className={`h-100 mb-0 bg-white ${styles.post}`}>
                {renderPost()}
                <figcaption className={`px-3 pb-3 ${styles.caption}`}>
                    <div className={styles.captionAuthor}>{author}</div>
                    <div className={styles.captionDate}>{dateConverted} - {time}</div>
                    <div className={styles.captionDescription}>{caption}</div>

                </figcaption>
            </figure>
        </div>

    )
}

export default PostComponent;


