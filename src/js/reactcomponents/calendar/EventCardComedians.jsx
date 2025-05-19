import React, { useState, useEffect } from 'react';
import {Loader} from '../utils/Loader';

const AJAX_URL = 'https://tscc.local/web/wp-admin/admin-ajax.php';

const secretComedianTitles = [
  'top-secret-acts-tba',
  'acts-yet-to-be-confirmed',
  'special-celebrity-guest'
];

export const EventCardComedians = ({ event }) => {
  const [comediansData, setComediansData] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (event?.comedians?.length) {
      fetchComedians(event.comedians);
    }
  }, [event.comedians]);

  const isSecretComedian = ({ comedian }) => {
    console.log('secret ', secretComedianTitles.includes(comedian.name))
    return secretComedianTitles.includes(comedian.name)
  }

  const renderSecretComedianStrapline = (comedian) => {
    switch (comedian.name) {
      case 'top-secret-acts-tba':
        return 'acts to be announced';
      case 'acts-yet-to-be-confirmed':
        return 'acts yet to be confirmed';
      default:
        return 'celebrity guest';
    }
  };


  const fetchComedians = async (ids) => {
    try {
      const results = [];

      for (const id of ids) {
        const params = new URLSearchParams({
          action: 'jw_get_comedian_for_event',
          comedian_id: id,
          mc_id: event.mcID || ''
        }).toString();

        const res = await fetch(AJAX_URL, {
          method: 'POST',
          headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
          },
          body: params
        });

        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const comedian = data.comedian_for_event?.[0];

        if (comedian) results.push(comedian);
      }

      setComediansData(results);
      setLoading(false);
      console.log('Fetched comedians:', results);
    } catch (error) {
      console.error('Error fetching comedians:', error);
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <Loader />
    );
  }

  return (
    <>
      {comediansData.map((comedian, index) => (
        <li
          key={index}
          className="w-full md:w-1/3 px-2 mb-4 flex flex-col items-center relative"
        >
          {isSecretComedian({comedian}) ? (
              <>
              <a href={comedian.link} className="absolute inset-0 z-10"></a>
              <div className="w-full overflow-hidden mb-2 h-full aspect-[1/1] relative before:absolute before:inset-0 before:bg-black before:opacity-0 hover:before:opacity-50 transition-opacity">
                <p className="font-heading m-0 px-2 py-1 text-center leading-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-primary">{renderSecretComedianStrapline(comedian)}</p>
                <img src="https://thetopsecretcomedyclub.co.uk/wp-content/themes/TOPSECRET-3/images/secret.png" className="object-cover w-full h-full" />
              </div>
              </>
          ) : (
            <>
            <a href={comedian.link} className="absolute inset-0 z-10"></a>
            <div className="w-full overflow-hidden mb-2 h-full aspect-[1/1] relative before:absolute before:inset-0 before:bg-black before:opacity-0 hover:before:opacity-50 transition-opacity">
              <p className="font-heading m-0 px-2 py-1 text-center leading-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-primary">{comedian.title}</p>
              <img src={comedian.image_medium} className="object-cover w-full h-full" />
            </div>
            </>
          )}
        </li>
      ))}
    </>
  );
};

export default EventCardComedians;