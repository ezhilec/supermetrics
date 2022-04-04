import axios from 'axios';

const baseApiUrl = 'http://127.0.0.1:4001'

export const getPostsRequest = (page, perPage) => {
  return axios.get(`${baseApiUrl}/posts?page=${page}&perPage=${perPage}`)
}

export const getUsersRequest = (page, perPage) => {
  return axios.get(`${baseApiUrl}/users?page=${page}&perPage=${perPage}`)
}

export const getUserRequest = (id) => {
  return axios.get(`${baseApiUrl}/users/${id}`)
}