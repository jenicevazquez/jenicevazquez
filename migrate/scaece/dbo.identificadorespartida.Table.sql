/****** Object:  Table [dbo].[identificadorespartida]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[identificadorespartida](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clave] [varchar](3) NULL,
	[complemento1] [varchar](20) NULL,
	[complemento2] [varchar](30) NULL,
	[complemento3] [varchar](40) NULL,
	[partida_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_identificadorespartida] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
