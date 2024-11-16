import { ImgHTMLAttributes } from "react";

export default function ApplicationLogo(
    props: ImgHTMLAttributes<HTMLImageElement>
) {
    return (
        <img {...props} src="/storage/images/ServiSeek.png" alt="ServiSeek" />
    );
}
