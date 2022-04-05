import React from 'react'
import { render, unmountComponentAtNode } from 'react-dom'
import { act } from 'react-dom/test-utils'

import Posts from '../components/Posts/Posts'
import PostDTO from '../DTOs/PostDTO'
import { MemoryRouter } from 'react-router'

let container = null
beforeEach(() => {
  container = document.createElement('div')
  document.body.appendChild(container)
})

afterEach(() => {
  unmountComponentAtNode(container)
  container.remove()
  container = null
})

it('renders with or without a name', () => {
  act(() => {
    render(<MemoryRouter initialEntries={['/dashboard']}>
      <Posts
        posts={[]}
        isLoading={false}
        page={1}
        perPage={1}
        total={1}
        handleSetPage={() => {}}
        isShowTitle={false}
        isShowPagination={false}
      /></MemoryRouter>, container)
  })
  expect(container.textContent).toBe('List is empty yet')

  act(() => {
    render(<MemoryRouter initialEntries={['/dashboard']}><Posts
      posts={[
        new PostDTO({
          id: 'id1',
          fromName: 'fromName',
          fromId: 'fromId',
          message: 'message1',
          type: 'type',
          createdAt: 'createdAt',
        }),
        new PostDTO({
          id: 'id2',
          fromName: 'fromName',
          fromId: 'fromId',
          message: 'message2',
          type: 'type',
          createdAt: 'createdAt',
        })
      ]}
      isLoading={false}
      page={1}
      perPage={1}
      total={1}
      handleSetPage={() => {}}
      isShowTitle={false}
      isShowPagination={false}
    /></MemoryRouter>, container)
  })
  expect(container.textContent).toContain('message1')
  expect(container.textContent).toContain('message2')

})