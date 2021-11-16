SELECT
    c.id,
    c.carnumber,
    COUNT(c.id) anzahl
FROM caravan_dates d
         JOIN caravans c ON d.caravan_id = c.id
         JOIN caravan_dates dd
              ON dd.id!=d.id
                  AND dd.caravan_id=d.caravan_id
                  AND (DATE(d.from) BETWEEN dd.from AND dd.until OR DATE(d.until) BETWEEN dd.from AND dd.until)
GROUP BY c.id
HAVING anzahl > 1
ORDER BY anzahl DESC;

-- new tables
price_types, materials, material_categories, services, service_categories, service_materials, service_requests, service_requests_services
