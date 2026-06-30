import React from 'react';

const PostTable = ({ posts, onStatusChange }) => {
    return (
        <table border="1" cellPadding="10" style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
                <tr>
                    <th>عنوان پست</th>
                    <th>نویسنده</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                {posts.map(post => (
                    <tr key={post.id}>
                        <td>{post.title}</td>
                        <td>{post.author_name}</td>
                        <td>
                            <button 
                                onClick={() => onStatusChange(post.id, 'approved')}
                                style={{ backgroundColor: 'green', color: 'white', marginRight: '5px', cursor: 'pointer' }}
                            >
                                تایید
                            </button>
                            <button 
                                onClick={() => onStatusChange(post.id, 'rejected')}
                                style={{ backgroundColor: 'red', color: 'white', cursor: 'pointer' }}
                            >
                                رد پست
                            </button>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
};

export default PostTable;
