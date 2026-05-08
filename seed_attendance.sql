USE `D&G`;
INSERT INTO workers (id, name, role_name, project, photo_name, descriptor_json) VALUES
('W-0012','Jose Reyes','Carpenter','Rizal Residential Complex',NULL,'[]'),
('W-0018','Maria Lim','Foreman','Rizal Residential Complex',NULL,'[]'),
('W-0024','Roberto Dizon','Mason','San Pablo Commercial Hub',NULL,'[]'),
('W-0031','Ana Cruz','Steel Worker','Rizal Residential Complex',NULL,'[]'),
('W-0037','Bong Pascual','Electrician','San Pablo Commercial Hub',NULL,'[]')
ON DUPLICATE KEY UPDATE
name = VALUES(name),
role_name = VALUES(role_name),
project = VALUES(project),
photo_name = VALUES(photo_name),
descriptor_json = VALUES(descriptor_json);

INSERT INTO attendance_logs (worker_id, worker_name, worker_role, project, date_key, time_in, status, score, scan_source) VALUES
('W-0012','Jose Reyes','Carpenter','Rizal Residential Complex',CURDATE(),'07:02:00','Present',0.18,'group_photo'),
('W-0018','Maria Lim','Foreman','Rizal Residential Complex',CURDATE(),'07:45:00','Late',0.22,'group_photo'),
('W-0031','Ana Cruz','Steel Worker','Rizal Residential Complex',CURDATE(),'06:58:00','Present',0.16,'group_photo')
ON DUPLICATE KEY UPDATE
worker_name = VALUES(worker_name),
worker_role = VALUES(worker_role),
time_in = VALUES(time_in),
status = VALUES(status),
score = VALUES(score),
scan_source = VALUES(scan_source);
