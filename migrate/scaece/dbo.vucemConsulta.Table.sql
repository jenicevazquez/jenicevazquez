/****** Object:  Table [dbo].[vucemConsulta]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[vucemConsulta](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tipo] [int] NULL,
	[consulta] [varchar](20) NULL,
	[vucem_id] [int] NULL
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
