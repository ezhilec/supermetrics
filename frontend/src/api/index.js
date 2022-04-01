import axios from 'axios';

const baseApiUrl = 'http://127.0.0.1:4001'

export const getPostsRequest = (page) => {
  return axios.get(`${baseApiUrl}/posts?page=${page}`)
}