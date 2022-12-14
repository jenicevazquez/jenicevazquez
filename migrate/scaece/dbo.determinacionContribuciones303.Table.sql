/****** Object:  Table [dbo].[determinacionContribuciones303]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[determinacionContribuciones303](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pais] [varchar](5) NULL,
	[fraccion] [varchar](8) NULL,
	[secuencia] [int] NULL,
	[valorMercancia] [decimal](18, 2) NULL,
	[montoIGI] [decimal](18, 2) NULL,
	[totalarancel] [decimal](18, 2) NULL,
	[moneda] [varchar](5) NULL,
	[montoexento] [decimal](18, 2) NULL,
	[observaciones] [varchar](250) NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_determinacionContribuciones303] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
