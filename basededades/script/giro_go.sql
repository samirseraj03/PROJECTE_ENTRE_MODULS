-- Supabase AI is experimental and may produce incorrect answers
-- Always verify the output before executing

create table
  locations (
    id bigint primary key generated always as identity,
    longitude double precision,
    latitude double precision
  );


create table
  users (
    id bigint primary key generated always as identity,
    name text,
    email text,
    password : text
    user_type : text,
    driving_type text,
    location_id bigint references locations (id),
    address text,
    price_type text,
    static_km double precision,
    reviews text,
    photo text,
    created_at timestamp with time zone,
    is_available boolean
  );


  
  create table
  user_types (
    id bigint primary key generated always as identity,
    user_id bigint references users (id),
    type text
  );


  create table
  cars (
    id bigint primary key generated always as identity,
    user_id bigint references users (id),
    type text,
    photo text
  );



create table
  travels (
    id bigint primary key generated always as identity,
    created_at timestamp with time zone,
    finalized_at timestamp with time zone,
    driver_id bigint references users (id),
    user_id bigint references users (id),
    total double precision,
    distance_km double precision,
    initial_lat double precision,
    initial_lon double precision,
    finalized_lat double precision,
    finalized_lon double precision,
    initial_address text,
    finalized_address text
  );


  create table
  ratings (
    id bigint primary key generated always as identity,
    travel_id bigint references travels (id),
    driver_id bigint references users (id),
    user_id bigint references users (id),
    rating double precision,
    comments text
  );

