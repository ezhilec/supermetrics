import React, { useEffect } from 'react'
import Posts from '../components/Posts/Posts'
import { useDispatch, useSelector } from 'react-redux'
import { getPosts, setPage } from '../actions/PostsActions'

function PostsContainer () {
  const posts = useSelector(state => state.posts)
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(getPosts(posts.page, posts.perPage))
  }, [posts.page])

  return <Posts
    posts={posts.list}
    error={posts.error}
    isLoading={posts.isLoading}
    page={posts.page}
    perPage={posts.perPage}
    total={posts.total}
    handleSetPage={(page) => dispatch(setPage(page))}
    isShowTitle={true}
    isShowPagination={true}
  />

}

export default PostsContainer