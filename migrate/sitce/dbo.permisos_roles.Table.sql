/****** Object:  Table [dbo].[permisos_roles]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[permisos_roles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[roles_id] [int] NULL,
	[permiso_id] [int] NULL
) ON [PRIMARY]

GO
