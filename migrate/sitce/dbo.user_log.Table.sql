/****** Object:  Table [dbo].[user_log]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_log](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[login_time] [datetime] NULL,
	[id_user] [int] NULL
) ON [PRIMARY]

GO
