import trans from "./../trans";

export default function language(code, fields = {}) {
    return trans(code, fields);
};