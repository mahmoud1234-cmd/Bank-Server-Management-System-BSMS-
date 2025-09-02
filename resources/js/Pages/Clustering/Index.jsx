import React from 'react';

export default function Index({ title, description }) {
  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold">{title}</h1>
      <p className="mt-2 text-gray-600">{description}</p>

      <div className="mt-6">
        <p>📊 Ici tu vas afficher les données de clustering</p>
      </div>
    </div>
  );
}
