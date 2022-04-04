import { getPostsRequest } from '../api'

const PREFIX = 'SUPERMETRICS_POSTS__'

export const GET_POSTS_REQUEST = PREFIX + 'GET_POSTS_REQUEST'
export const GET_POSTS_SUCCESS = PREFIX + 'GET_POSTS_SUCCESS'
export const GET_POSTS_ERROR = PREFIX + 'GET_POSTS_ERROR'
export const SET_PAGE = PREFIX + 'SET_PAGE'

export const getPosts = (page, perPage) => async dispatch => {
  dispatch({
    type: GET_POSTS_REQUEST,
  })

  try {
    const response = await getPostsRequest(page, perPage)
    dispatch({
      type: GET_POSTS_SUCCESS,
      payload: response.data.data,
    })
  } catch (e) {
    dispatch({
      type: GET_POSTS_ERROR,
      payload: "Can't get posts list",
    })
  }
}

export const setPage = (payload) => {
  return {
    type: SET_PAGE,
    payload,
  }
}