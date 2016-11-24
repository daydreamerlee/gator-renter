select * from user_messages um
left join users from_usr on (usr.id = um.from_user_id) 
left join apartment on apt (apt.owner_user_id = ) where id in (
	select max(um.id) from user_messages um
	where um.to_user_id = 171
	group by um.from_user_id, um.apartment_id 
);