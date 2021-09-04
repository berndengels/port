SELECT
    c.carnumber,
    d.`from`,
    d.`until`
FROM caravan_dates d
         JOIN caravans c ON c.id=d.caravan_id
WHERE (SELECT
           COUNT(caravan_id) cars
       FROM caravan_dates
       WHERE caravan_id=d.caravan_id
       GROUP BY caravan_id
      ) > 1
ORDER BY c.carnumber, d.`from`;
