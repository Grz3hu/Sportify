--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1 (Debian 15.1-1.pgdg110+1)
-- Dumped by pg_dump version 15.1 (Debian 15.1-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: users; Type: TABLE; Schema: public; Owner: devuser
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(60) NOT NULL,
    is_admin boolean DEFAULT false NOT NULL,
    enabled boolean DEFAULT true NOT NULL,
    created_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.users OWNER TO devuser;

--
-- Name: admins; Type: VIEW; Schema: public; Owner: devuser
--

CREATE VIEW public.admins AS
 SELECT users.user_id,
    users.email,
    users.password,
    users.is_admin,
    users.enabled,
    users.created_at
   FROM public.users
  WHERE (users.is_admin = true);


ALTER TABLE public.admins OWNER TO devuser;

--
-- Name: events; Type: TABLE; Schema: public; Owner: devuser
--

CREATE TABLE public.events (
    event_id integer NOT NULL,
    category character varying(250) NOT NULL,
    date date NOT NULL,
    location character varying(300) NOT NULL,
    picture character varying(1000) NOT NULL,
    creator_id integer NOT NULL
);


ALTER TABLE public.events OWNER TO devuser;

--
-- Name: events_event_id_seq; Type: SEQUENCE; Schema: public; Owner: devuser
--

CREATE SEQUENCE public.events_event_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.events_event_id_seq OWNER TO devuser;

--
-- Name: events_event_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: devuser
--

ALTER SEQUENCE public.events_event_id_seq OWNED BY public.events.event_id;


--
-- Name: user_event; Type: TABLE; Schema: public; Owner: devuser
--

CREATE TABLE public.user_event (
    user_id integer,
    event_id integer
);


ALTER TABLE public.user_event OWNER TO devuser;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: devuser
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO devuser;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: devuser
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.user_id;


--
-- Name: users_info; Type: TABLE; Schema: public; Owner: devuser
--

CREATE TABLE public.users_info (
    user_info_id integer NOT NULL,
    name character varying(300) NOT NULL,
    phone_number character varying(11) NOT NULL,
    profile_picture character varying(1000) NOT NULL
);


ALTER TABLE public.users_info OWNER TO devuser;

--
-- Name: users_info_user_info_id_seq; Type: SEQUENCE; Schema: public; Owner: devuser
--

CREATE SEQUENCE public.users_info_user_info_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_info_user_info_id_seq OWNER TO devuser;

--
-- Name: users_info_user_info_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: devuser
--

ALTER SEQUENCE public.users_info_user_info_id_seq OWNED BY public.users_info.user_info_id;


--
-- Name: users_sessions; Type: TABLE; Schema: public; Owner: devuser
--

CREATE TABLE public.users_sessions (
    session_id integer NOT NULL,
    user_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    destoryed_at timestamp without time zone DEFAULT ((now())::date + 1)
);


ALTER TABLE public.users_sessions OWNER TO devuser;

--
-- Name: users_sessions_session_id_seq; Type: SEQUENCE; Schema: public; Owner: devuser
--

CREATE SEQUENCE public.users_sessions_session_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_sessions_session_id_seq OWNER TO devuser;

--
-- Name: users_sessions_session_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: devuser
--

ALTER SEQUENCE public.users_sessions_session_id_seq OWNED BY public.users_sessions.session_id;


--
-- Name: users_sessions_user_id_seq; Type: SEQUENCE; Schema: public; Owner: devuser
--

CREATE SEQUENCE public.users_sessions_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_sessions_user_id_seq OWNER TO devuser;

--
-- Name: users_sessions_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: devuser
--

ALTER SEQUENCE public.users_sessions_user_id_seq OWNED BY public.users_sessions.user_id;


--
-- Name: events event_id; Type: DEFAULT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.events ALTER COLUMN event_id SET DEFAULT nextval('public.events_event_id_seq'::regclass);


--
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: users_info user_info_id; Type: DEFAULT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users_info ALTER COLUMN user_info_id SET DEFAULT nextval('public.users_info_user_info_id_seq'::regclass);


--
-- Name: users_sessions session_id; Type: DEFAULT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users_sessions ALTER COLUMN session_id SET DEFAULT nextval('public.users_sessions_session_id_seq'::regclass);


--
-- Name: users_sessions user_id; Type: DEFAULT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users_sessions ALTER COLUMN user_id SET DEFAULT nextval('public.users_sessions_user_id_seq'::regclass);


--
-- Name: events_event_id_seq; Type: SEQUENCE SET; Schema: public; Owner: devuser
--

SELECT pg_catalog.setval('public.events_event_id_seq', 1, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: devuser
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


--
-- Name: users_info_user_info_id_seq; Type: SEQUENCE SET; Schema: public; Owner: devuser
--

SELECT pg_catalog.setval('public.users_info_user_info_id_seq', 1, true);


--
-- Name: users_sessions_session_id_seq; Type: SEQUENCE SET; Schema: public; Owner: devuser
--

SELECT pg_catalog.setval('public.users_sessions_session_id_seq', 1, true);


--
-- Name: users_sessions_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: devuser
--

SELECT pg_catalog.setval('public.users_sessions_user_id_seq', 1, false);


--
-- Name: events events_pk; Type: CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pk PRIMARY KEY (event_id);


--
-- Name: users_info users_info_pk; Type: CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users_info
    ADD CONSTRAINT users_info_pk PRIMARY KEY (user_info_id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: user_event event_id; Type: FK CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.user_event
    ADD CONSTRAINT event_id FOREIGN KEY (event_id) REFERENCES public.events(event_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: events events_user_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_user_id_fk FOREIGN KEY (creator_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: user_event user_id; Type: FK CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.user_event
    ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: users_sessions user_session_id; Type: FK CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users_sessions
    ADD CONSTRAINT user_session_id FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: users_info users_info_users_user_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: devuser
--

ALTER TABLE ONLY public.users_info
    ADD CONSTRAINT users_info_users_user_id_fk FOREIGN KEY (user_info_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--
